<?php

namespace Evan\Routing\Events;

use Evan\Events\Event;

class AddRouteBeforeEvent extends Event
{
	protected $route_array;
	protected $routes;


	public function __construct(Array $route_array, Array $routes)
	{
		$this->route_array = $route_array;
		$this->routes = $routes;
	}

	public function getRouteArray()
	{
		return $this->route_array;
	}

	public function getRoutes()
	{
		return $this->routes;
	}

	public function setRouteArray(Array $route_array)
	{
		$this->route_array = $route_array;
	}

	public function setRoutes(Array $routes)
	{
		$this->routes = $routes;
	}
}