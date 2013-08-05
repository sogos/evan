<?php

namespace Evan\Routing\Events;

use Evan\Events\Event;
use Evan\Request\Request;

class RouteNotFoundEvent extends Event
{

	protected $uri;
	protected $route;
	protected $request;
	protected $app;

	public function __construct(Request $request, &$app)
	{
		$this->request = $request;
		$this->app = &$app;
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

	public function getApp()
	{
		return $this->app;
	}



	
}