<?php

namespace Evan\Controller;

use Evan\Controller\Events\ControllerFactoryEvent;
use Evan\Exception\Exception;
use Evan\Container\ContainerAccess;

class ControllerFactory extends ContainerAccess
{


	public function getDefaultController()
	{
		return $this->getController();
	}

	public function getController($ControllerClass = null) {

		$event_master = $this->get('event_master');
		$ControllerFactoryEvent = $event_master->triggerEvent(new ControllerFactoryEvent($ControllerClass), 'newControllerInstanceBefore');
		$ControllerClass = $ControllerFactoryEvent->getControllerClass();
		if(is_null($ControllerClass)) {
			throw new Exception("ControllerClass is empty");
			
		}
		$reflectorClass =  new \ReflectionClass($ControllerClass);

		if( $ControllerClass == "Evan\Controller\Controller" || ($reflectorClass->isInstantiable() && $reflectorClass->isSubclassOf("\Evan\Controller\Controller")))
		{
			if(null == $this->get('controller_'. $ControllerClass) ) {
				if($reflectorClass->hasMethod('__construct')) {
					$parameters_to_pass = array();
					$parameters = $reflectorClass->getMethod('__construct')->getParameters();
					foreach($parameters as $parameter) {
						if($parameter->getName() == "container") {
							$parameters_to_pass[$parameter->getPosition()] = $this->get('container');
						}
					}

					$this->set('controller_'. $ControllerClass, function ($this) use ($reflectorClass, $parameters_to_pass) {
						return $reflectorClass->newInstanceArgs($parameters_to_pass);
					});
				}
				
			}
			if(null !== $this->get('controller_'. $ControllerClass)) {
				return $this->get('controller_'. $ControllerClass);
			}
		}
		return null;
	}
}