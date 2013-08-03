<?php

namespace Evan\Routing;

interface RouteCollectorInterface
{
	public function addRoute (Array $route_array);

	public function getRoute ($alias);

	public function getRoutes();
}