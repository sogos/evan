<?php

namespace Evan\Routing\Events;

use Evan\Events\Event;

class AddRouteAfterEvent extends Event
{
	protected $route_array;
	protected $routes;
	protected $routes_after;


	public function __construct(Array $route_array, Array $routes, Array $routes_after)
	{
		$this->route_array = $route_array;
		$this->routes = $routes;
		$this->routes_after = $routes_after;
	}

	public function getRouteArray()
	{
		return $this->route_array;
	}

	public function getRoutes()
	{
		return $this->routes;
	}

	public function getRoutesAfter()
	{
		return $this->routes_after;
	}

	public function setRouteArray(Array $route_array)
	{
		$this->route_array = $route_array;
	}

	public function setRoutes(Array $routes)
	{
		$this->routes = $routes;
	}

	public function setRoutesAfter(Array $routes_after)
	{
		$this->routes_after = $routes_after;
	}
}