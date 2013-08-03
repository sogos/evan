<?php

use Evan\Request\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser as YamlParser;
use Evan\Exception\Exception as EvanException;
use Evan\Routing\RouteCollector;
use Evan\Events\Master as EventMaster;
use Evan\Routing\EventListeners\RouteListener;
use Evan\Routing\RouteMatcher;

require_once("../vendor/autoload.php");

$app = New \Pimple();

try{

// Plug Event Master
	$app['event_master'] = $app->share(function ($app) {
		return new EventMaster($app);
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
// $app['translator'] = function($app) {
// 	return new Translator($app['locale']);
// };

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
		return new Request($app);
	});


// Routing Configuration
	$app['config_routing_file'] = __DIR__. '/config/routing.yml';

	if(!isset($app['config_routing_file'])) {
		throw new EvanException("Routing file is not defined");	
	}

	// Route Matcher
	$app['route_matcher'] = $app->share(function ($app) {
		return new RouteMatcher($app);
	});


	$app['route_collector'] = $app->share(function ($app) {
		return new RouteCollector($app);
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




} catch (\Exception $e) {
	die("Oops: " . $e->getMessage());

}