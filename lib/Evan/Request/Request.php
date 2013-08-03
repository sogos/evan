<?php

namespace Evan\Request; 

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
		$this->app = $app;
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
			 //$controller = new $route['controller']($this, $this->app);

			 $reflector =  new \ReflectionClass($route['controller']);
			 if(!$reflector->hasMethod($route['action'])) {
			 	throw new \Exception("Action: '" . $route['action'] . "' not found in Controller " . $route['controller'], 1);	 	
			 }
			 $parameters = $reflector->getMethod($route['action'])->getParameters();
			foreach($parameters as $key => $parameter) {
				
				//echo "<pre>";
				//print_r(get_class_methods($parameter));
				
				if($parameter->getClass()) {
					echo $parameter->getClass()->getName();
				}
				if($parameter->isArray()) {
					echo "Array Asked";
				}
			}
			//die();
		}		
	}
}