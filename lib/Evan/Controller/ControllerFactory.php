<?php

namespace Evan\Controller;

use Evan\Controller\Events\ControllerFactoryEvent;
use Evan\Exception\Exception;

class ControllerFactory
{
	protected $app;

	public function __construct(&$app)
	{
		$this->app = &$app;
	}

	public function getDefaultController()
	{
		return $this->get();
	}

	public function get($ControllerClass = null) {

		$ControllerFactoryEvent = $this->app['event_master']->triggerEvent(new ControllerFactoryEvent($ControllerClass), 'newControllerInstanceBefore');
		$ControllerClass = $ControllerFactoryEvent->getControllerClass();
		if(is_null($ControllerClass)) {
			throw new Exception("ControllerClass is empty");
			
		}
		$reflectorClass =  new \ReflectionClass($ControllerClass);

		if( $ControllerClass == "Evan\Controller\Controller" || ($reflectorClass->isInstantiable() && $reflectorClass->isSubclassOf("\Evan\Controller\Controller")))
		{
			if(!isset($this->app['controller_'. $ControllerClass])) {
				if($reflectorClass->hasMethod('__construct')) {
					$parameters_to_pass = array();
					$parameters = $reflectorClass->getMethod('__construct')->getParameters();
					foreach($parameters as $parameter) {
						if($parameter->getName() == "app") {
							$parameters_to_pass[$parameter->getPosition()] = &$this->app;
						}
					}

					$this->app['controller_'. $ControllerClass] = function ($this) use ($reflectorClass, $parameters_to_pass) {
						return $reflectorClass->newInstanceArgs($parameters_to_pass);
					};
				}
				
			}
			if(isset($this->app['controller_'. $ControllerClass])) {
				return $this->app['controller_'. $ControllerClass];
			}
		}
		return null;
	}
}