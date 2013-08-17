<?php

use Evan\Request\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser as YamlParser;
use Evan\Container\Container;
use Evan\Exception\Exception as EvanException;
use Evan\Routing\RouteCollector;
use Evan\Events\Master as EventMaster;
use Evan\Routing\EventListeners\RouteListener;
use Evan\Routing\RouteMatcher;
use Evan\Controller\ControllerFactory;
use Evan\Logger\Doctrine\DoctrineSQLLogger;
use Evan\Logger\Doctrine\QueriesCollector;
use Doctrine\ORM\Tools\Setup;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Configuration as ORMConfiguration;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Mapping\Driver\DriverChain;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;


require_once(dirname(__FILE__). "/../vendor/autoload.php");
AnnotationRegistry::registerFile(__DIR__.'/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

$app = New \Pimple();
$app['app_path'] = dirname(__FILE__) . '/' ;
$app['root_path'] = dirname(__FILE__). '/../';
$app['web_path'] = dirname(__FILE__). '/../web/';
try{

// APP Container
	$app['container'] = $app->share(function (&$app) {
		return New Container($app);
	});


// Plug Event Master
	$app['event_master'] = $app->share(function ($app) {
		return new EventMaster($app['container']);
	});


// Event Listeners Configuration
	$app['config_listeners_file'] = __DIR__. '/config/listeners.yml';

	$listeners_yml = new Yaml();
	$listeners_parsed = $listeners_yml->parse($app['config_listeners_file']);

	if(is_array($listeners_parsed) && array_key_exists('event_listeners', $listeners_parsed)) {

		foreach($listeners_parsed['event_listeners'] as $alias => $values) {

			$the_listener = new $values['class']($app);
			foreach($values['subscribe'] as $event_alias => $callback) {
				$app['event_master']->subscribeToEvent('listener_' . $alias, $event_alias, $callback);
			}
			$app['listener_' . $alias] = $app->share(function ($app) use ($the_listener) {
				return $the_listener;
			});
		}
	}

// Twig Loading
	$app['twig_filesystem_location'] = __DIR__.'/Resources/views/';
	$app['twig_cache_path'] = __DIR__.'/cache/twig/';
	$app['twig.form.templates'] = array('form_div_layout.html.twig');
	$app['twig.loader.filesystem'] =  $app->share(function ($app) {
		return new \Twig_Loader_Filesystem($app['twig_filesystem_location']);
	});

	$app['twig.loader.array'] = $app->share(function ($app) {
		return new \Twig_Loader_Array($app['twig.templates']);
	});

	$app['twig.loader'] = $app->share(function ($app) {
		return new \Twig_Loader_Chain(array(
			$app['twig.loader.array'],
			$app['twig.loader.filesystem'],
			));
	});
	$app['charset'] = 'utf8';

	$app['debug'] = true;
	$app['twig'] = function ($app) {
		$app['twig.options'] = array();
		$app['twig.form.templates'] = array('form_div_layout.html.twig');
		$app['twig.path'] = array();
		$app['twig.templates'] = array();
		$app['twig.options'] = array_replace(
			array(
				'charset'          => $app['charset'],
				'debug'            => $app['debug'],
				'strict_variables' => $app['debug'],
				'cache'			   => $app['twig_cache_path']
				), $app['twig.options']
			);

		$twig = new \Twig_Environment($app['twig.loader'], $app['twig.options']);
		$twig->addGlobal('app', $app);
	//$twig->addExtension(new TwigCoreExtension());

		if ($app['debug']) {
			$twig->addExtension(new \Twig_Extension_Debug());
		}

	// if (class_exists('Symfony\Bridge\Twig\Extension\RoutingExtension')) {
	// 	if (isset($app['url_generator'])) {
	// 		$twig->addExtension(new RoutingExtension($app['url_generator']));
	// 	}

	// 	if (isset($app['translator'])) {
	// 		$twig->addExtension(new TranslationExtension($app['translator']));
	// 	}

	// 	if (isset($app['security'])) {
	// 		$twig->addExtension(new SecurityExtension($app['security']));
	// 	}

	// 	if (isset($app['form.factory'])) {
	// 		$app['twig.form.engine'] = $app->share(function ($app) {
	// 			return new TwigRendererEngine($app['twig.form.templates']);
	// 		});

	// 		$app['twig.form.renderer'] = $app->share(function ($app) {
	// 			return new TwigRenderer($app['twig.form.engine'], $app['form.csrf_provider']);
	// 		});

	// 		$twig->addExtension(new FormExtension($app['twig.form.renderer']));

 //                    // add loader for Symfony built-in form templates
	// 		$reflected = new \ReflectionClass('Symfony\Bridge\Twig\Extension\FormExtension');
	// 		$path = dirname($reflected->getFileName()).'/../Resources/views/Form';
	// 		$app['twig.loader']->addLoader(new \Twig_Loader_Filesystem($path));
	// 	}
	//}

		return $twig;
	};

// Request processing 
	$app['request'] = $app->share(function ($app) {
		return new Request($app['container']);
	});


// Routing Configuration
	$app['config_routing_file'] = __DIR__. '/config/routing.yml';

	if(!isset($app['config_routing_file'])) {
		throw new EvanException("Routing file is not defined");	
	}

	// Route Matcher
	$app['route_matcher'] = $app->share(function ($app) {
		return new RouteMatcher($app['container']);
	});


	$app['route_collector'] = $app->share(function ($app) {
		return new RouteCollector($app['container']);
	});

	$app['routing_schema'] = $app->share(function ($app) {
		$route_yml = new Yaml();
		$route_parsed = $route_yml->parse($app['config_routing_file']);
		if(!is_array($route_parsed) &&
			( sizeof($route_parsed) == 0 
				|| array_key_exists('routing', $route_parsed) 
				)
			) {
			throw new EvanException("Routing file doesn't contain any route..");	
	}
	foreach($route_parsed['routing'] as $alias => $values) {
		$app['route_collector']->addRoute(array( $alias => $values));
	}
	return $app['route_collector']->getRoutes();
});


		$app['DoctrineLoggerChain'] = $app->share(function ($app) {
		return New \Doctrine\DBAL\Logging\LoggerChain();
	});

	$app['BaseSQLLogger'] = $app->share(function ($app) {
		return new DoctrineSQLLogger($app['container']);

	});

	$app['queries_collector'] =  $app->share(function ($app) {
		return new QueriesCollector();
	});

	$app['DoctrineLoggerChain']->addLogger($app['BaseSQLLogger']);

	$app['application_parameters_file'] = __DIR__. '/config/parameters.yml';
	$parameters_yml = new Yaml();
	$parameters_parsed = $parameters_yml->parse($app['application_parameters_file']);

	$app['dbs.options'] = array();

	if(array_key_exists("bdds", $parameters_parsed) && sizeof($parameters_parsed["bdds"]) > 0) {
		
		foreach($parameters_parsed['bdds'] as $alias => $arguments)
		{
			if( array_key_exists('driver', $arguments)
				&&  array_key_exists('user', $arguments)
				&&  array_key_exists('dbname', $arguments)
				&&  array_key_exists('host', $arguments)) 
			{
				$app['dbs.options'] = array_merge($app['dbs.options'], array($alias => $arguments)); 
			}
		}
	}

	$app['db.default_options'] = array(
		'driver'   => 'pdo_mysql',
		'dbname'   => null,
		'host'     => 'localhost',
		'user'     => 'root',
		'password' => null,
		'port'     => null,
		);

	$app['dbs.options.initializer'] = $app->protect(function () use ($app) {
		static $initialized = false;

		if ($initialized) {
			return;
		}

		$initialized = true;

		if (!isset($app['dbs.options'])) {
			$app['dbs.options'] = array('default' => isset($app['db.options']) ? $app['db.options'] : array());
		}

		$tmp = $app['dbs.options'];
		foreach ($tmp as $name => &$options) {
			$options = array_replace($app['db.default_options'], $options);

			if (!isset($app['dbs.default'])) {
				$app['dbs.default'] = $name;
			}
		}
		$app['dbs.options'] = $tmp;
	});

	$app['dbs'] = $app->share(function ($app) {
		$app['dbs.options.initializer']();

		$dbs = new \Pimple();
		foreach ($app['dbs.options'] as $name => $options) {
			if ($app['dbs.default'] === $name) {
                    // we use shortcuts here in case the default has been overridden
				$config = $app['db.config'];
				$manager = $app['db.event_manager'];
			} else {
				$config = $app['dbs.config'][$name];
				$manager = $app['dbs.event_manager'][$name];
			}

			$dbs[$name] = $dbs->share(function ($dbs) use ($options, $config, $manager) {
				return DriverManager::getConnection($options, $config, $manager);
			});
		}

		return $dbs;
	});

	$app['dbs.config'] = $app->share(function ($app) {
		$app['dbs.options.initializer']();

		$configs = new \Pimple();
		foreach ($app['dbs.options'] as $name => $options) {
			$configs[$name] = new Configuration();

			 if (isset($app['DoctrineLoggerChain']) ) {
				$configs[$name]->setSQLLogger($app['DoctrineLoggerChain']);
			 }
		}

		return $configs;
	});

	$app['dbs.event_manager'] = $app->share(function ($app) {
		$app['dbs.options.initializer']();

		$managers = new \Pimple();
		foreach ($app['dbs.options'] as $name => $options) {
			$managers[$name] = new EventManager();
		}

		return $managers;
	});

        // shortcuts for the "first" DB
	$app['db'] = $app->share(function ($app) {
		$dbs = $app['dbs'];

		return $dbs[$app['dbs.default']];
	});

	$app['db.config'] = $app->share(function ($app) {
		$dbs = $app['dbs.config'];

		return $dbs[$app['dbs.default']];
	});

	$app['db.event_manager'] = $app->share(function ($app) {
		$dbs = $app['dbs.event_manager'];

		return $dbs[$app['dbs.default']];
	});



// driver chain



	$app['entityManager'] = $app->share(function ($app) {
		$doctrine_config = new ORMConfiguration;

		$doctrine_config->setSQLLogger($app['DoctrineLoggerChain']);

		if ($app['debug']) {
			$doctrine_cache = new \Doctrine\Common\Cache\ArrayCache;
			$doctrine_config->setAutoGenerateProxyClasses(true);
		} else {
			$doctrine_cache = new \Doctrine\Common\Cache\ApcCache;
			$doctrine_config->setAutoGenerateProxyClasses(false);
		}
		$driverChain = new DriverChain();
	// Annotation
		// $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();
		// $annotationDriver = Doctrine\ORM\Mapping\Driver\AnnotationDriver::create(array(__DIR__),$annotationReader);
	// Yaml
		$yamlDriver = new \Doctrine\ORM\Mapping\Driver\YamlDriver(array(
			'Evan\\Entity' => __DIR__.'/../lib/Evan/Orm/',
			'Evan\\Entity2' => __DIR__.'/../lib/Evan/Orm2/',
			), '.orm.yml');



//		$driverChain->addDriver($annotationDriver, 'Entity');
		$driverChain->addDriver($yamlDriver,'Evan\Entity');
		$driverChain->setDefaultDriver($yamlDriver);
		$doctrine_config->setMetadataCacheImpl($doctrine_cache);
		$doctrine_config->setMetadataDriverImpl($driverChain);
		$doctrine_config->setQueryCacheImpl($doctrine_cache);
		$doctrine_config->setProxyDir(__DIR__.'/cache/doctrine_proxies/');
		$doctrine_config->setProxyNamespace('Evan\Proxies');
		$entityManager = EntityManager::create($app['dbs']['bdd1'], $doctrine_config);
		return $entityManager;

	});


//var_dump($app['doctrine_config']);

$app['controller_factory'] = $app->share(function ($app)  {
	return new ControllerFactory($app['container'] );
});

$app['time'] = function ($app) {
	return (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]);
};



} catch (\Exception $e) {
	echo get_class($e);
	die("Oops: " . $e->getMessage());

}

return $app;