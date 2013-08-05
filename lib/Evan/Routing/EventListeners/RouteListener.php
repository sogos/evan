<?php

namespace Evan\Routing\EventListeners;

use Evan\Events\EventListenerInterface;
use Evan\Routing\Events\AddRouteBeforeEvent;
use Evan\Routing\Events\AddRouteAfterEvent;
use Evan\Routing\Events\RouteNotFoundEvent;
use Evan\Controller\Controller as BaseController;

class RouteListener implements EventListenerInterface
{

	public function addRouteBefore(AddRouteBeforeEvent $event) {
		return $event;
	}

	/*
	* param $arguments array( 'before', 'route_array', 'after')
	* return array after
	*/
	public function addRouteAfter(AddRouteAfterEvent $event) {
		$current_route_array = $event->getRouteArray();
		$routes_after = $event->getRoutesAfter();
		$languages = array('fr', 'en', 'ru');
		foreach ($languages as $lang) {
			$current_alias_name = array_keys($current_route_array)[0];
			$alias_name = $lang . '_' . $current_alias_name;
				$lang_route  = '/' . $lang . $current_route_array[$current_alias_name]['route'];
			$route_array = array();
			$route_array[$alias_name] = $current_route_array[$current_alias_name];
			$route_array[$alias_name]['route'] = $lang_route;
			$routes_after = array_merge($routes_after, $route_array);
		}
		$event->setRoutesAfter($routes_after);
		return $event;
	}

	public function routeNotFound(RouteNotFoundEvent $event) {

		$app = $event->getApp();
		$ControllerFactory = $app['controller_factory'];
		$controller = $ControllerFactory->getDefaultController();
		$controller->routenotFound404($event->getRequest());
		$event->stopPropagation();
		return $event;
	}
}