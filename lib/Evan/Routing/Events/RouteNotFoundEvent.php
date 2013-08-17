<?php

namespace Evan\Routing\Events;

use Evan\Events\Event;
use Evan\Request\Request;
use Evan\Controller\ControllerFactory;

class RouteNotFoundEvent extends Event
{

	protected $uri;
	protected $route;
	protected $request;
	protected $ControllerFactory;

	public function __construct(Request $request,ControllerFactory &$ControllerFactory)
	{
		$this->request = $request;
		$this->ControllerFactory = &$ControllerFactory;
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getUri()
	{
		return $this->request->getUri();
	}

	public function setRoute($route)
	{
		$this->route = $route;
	}

	public function getControllerFactory()
	{
		return $this->ControllerFactory;
	}



	
}