<?php

namespace Evan\Controller\Events;

use Evan\Events\Event;

class ControllerFactoryEvent extends Event
{
	protected $controller_class;

	public function __construct ($controller_class){
		$this->controller_class = $controller_class;
	}

	public function getControllerClass()
	{
		return $this->controller_class;
	}

	public function setControllerClass($controller_class)
	{
		$this->controller_class = $controller_class;
	}
}