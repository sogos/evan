<?php

namespace Evan\Routing;

use Evan\Routing\Events\RouteNotFoundEvent;

class RouteMatcher
{

	protected $routes = array();

	public function findRoute($uri, Array $routing_schema, $method )
	{

		$uri = parse_url($uri)['path'];

		$uri_exploded = explode("/", $uri);
		$uri_item_count = sizeof($uri_exploded);
		foreach($routing_schema as $route) {
			$methods = explode("|", $route['methods']);
			if(!in_array($method,$methods)) {
				continue;
			} 
			$route_exploded = explode("/", $route["route"]);
			if(sizeof($route_exploded) ==  $uri_item_count ) {
				foreach($route_exploded as $key => $item_exploded) {
					if($item_exploded == $uri_exploded[$key]) {
					
					} elseif(preg_match('/{.*}/', $item_exploded)) {
					
					} else {
						continue 2;
					}
				}

			} else {
				continue;
			}
			//die();
			return $route;
		}
		//die();
		return null;

	}
}