<?php

namespace Evan\Request; 

use Evan\Routing\Events\RouteNotFoundEvent;

class Request
{

	protected $server_method;
	protected $uri;
	protected $lang;

	public function __construct(&$app) {

		$this->server_method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $_SERVER['REQUEST_URI'];
		try {
			$this->lang = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		} catch(\Exception $e) {
			die($e->getMessage());
		}
		$this->app = &$app;
	}

	public function getMethod()
	{
		return $this->server_method;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getBrowserLang()
	{
		return $this->lang;
	}

	public function handle() {
		$route = $this->app['route_matcher']->findRoute($this->getUri(), $this->app['routing_schema'], $this->getMethod());
		if($route) {
			//echo "<pre>";
			 
			$route_exploded = explode("/", $route['route']);
			$uri_exploded = explode("/", $this->getUri());
			 $reflector =  new \ReflectionClass($route['controller']);
			 if(!$reflector->hasMethod($route['action'])) {
			 	throw new \Exception("Action: '" . $route['action'] . "' not found in Controller " . $route['controller'], 1);	 	
			 }
			 $parameters = $reflector->getMethod($route['action'])->getParameters();
			 $parameters_to_pass = array();
			foreach($parameters as $key => $parameter) {
				if($parameter->getClass()) {
					if($parameter->getClass()->getName() == "Evan\Request\Request") {
						$parameters_to_pass[$parameter->getPosition()] = $this;
					}

				} elseif(in_array("{" . $parameter->getName() . "}", $route_exploded)) {
							$uri_position = array_search("{" . $parameter->getName() . "}", $route_exploded);
							$parameters_to_pass[$parameter->getPosition()] = $uri_exploded[$uri_position];
				} else {

					if(!$parameter->isOptional()) {
						throw new \Exception("Controller: ". $route['controller'] ." action: " . $route['action'] . " ask for unknow parameter" . $parameter->getName(), 1);
					}
				}


			}
			$this->app['controller_factory']->get($route['controller']);
			call_user_func_array(array($this->app['controller_'. $route['controller']], $route['action']), $parameters_to_pass);

		} else {
			$route_not_found_event = $this->app['event_master']->triggerEvent(new RouteNotFoundEvent($this, $this->app), 'routeNotFound');
		}		
	}
}