<?php

namespace Evan\Routing;


class RouteMatcher
{

	protected $routes = array();

	public function findRoute($uri, Array $routing_schema, $method )
	{
		$uri_exploded = explode("/", $uri);
		$uri_item_count = sizeof($uri_exploded);
		foreach($routing_schema as $route) {
			$route_exploded = explode("/", $route["route"]);
			if(sizeof($route_exploded) ==  $uri_item_count ) {
				foreach($route_exploded as $key => $item_exploded) {
					if($item_exploded == $uri_exploded[$key]) {
						echo "Criteria Match";
					} elseif(preg_match('/{.*}/', $item_exploded)) {
						echo "Criteria Match";
					} else {
						continue 2;
					}
				}

			}
			return $route;
		}
		return null;

	}
}