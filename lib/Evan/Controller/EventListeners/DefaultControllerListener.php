<?php

namespace Evan\Controller\EventListeners;

use Evan\Events\EventListenerInterface;

class DefaultControllerListener implements EventListenerInterface
{
	public function newControllerInstanceBefore($event) {

		$controller_class = $event->getControllerClass();
		if(is_null($controller_class)) {
			$controller_class = "Evan\Controller\Controller";
			$event->setControllerClass($controller_class);
		}
		$event->stopPropagation();
		return $event;
	}
}