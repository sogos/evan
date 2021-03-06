<?php

namespace Evan\Routing;


use Evan\Container\ContainerAccess;
use Evan\Routing\Events\AddRouteBeforeEvent;
use Evan\Routing\Events\AddRouteAfterEvent;



class RouteCollector extends ContainerAccess  implements RouteCollectorInterface
{

	protected $routes = array();


	public function addRoute (Array $route_array) {
		$route_before_event = $this->get('event_master')->triggerEvent(new AddRouteBeforeEvent($route_array, $this->routes), 'addRouteBefore');
		$routes = $route_before_event->getRoutes();
		$routes = array_merge($this->routes, $route_array);
		$route_after_event = $this->get('event_master')->triggerEvent(new AddRouteAfterEvent($route_array, $this->routes, $routes), 'addRouteAfter');
		$this->routes = $route_after_event->getRoutesAfter();
	}

	public function getRoute ($alias) {
		
	}

	public function getRoutes() {
		return $this->routes;
	}
}