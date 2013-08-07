<?php

namespace Evan\Container;

class Container
{

	private $app;
	private $permissions;

	public function __construct(&$app)
	{
		$this->app = &$app;
	}

	public function get($alias, $asking_class)
	{

		if(!empty($alias) && isset($this->app[$alias])) {
			if($this->getPermission($alias, $asking_class)) {
				return $this->app[$alias];
			}
		}
		return null;
	}

	public function set($alias, $asking_class, $value)
	{
		if($this->getPermission($alias, $asking_class, 'set')) {
		$this->app[$alias] = $value;
		}
	}

	private function getPermission($alias, $asking_class, $method = 'get') {
		$permissions = array(
			'get' => array(
				'route_matcher' => array(
					'Evan\Request\Request'
					),
				'routing_schema' => array(
					'Evan\Request\Request'
					),
				'controller_factory' => array(
					'Evan\Request\Request'
					),
				'container' => array(
					'Evan\Controller\ControllerFactory'
					)
				),
			'set' => array(

				)
		);
		if(($asking_class == "Evan\Controller\ControllerFactory" 
			|| $asking_class == "Evan\Request\Request" 
			) && preg_match('/controller_.*/', $alias))
		{
			return true;
		}
		if(($alias == "entityManager" || $alias == "twig" || $alias == "request" || $alias == "time" || $alias == "routing_schema") && preg_match('/.*Controller*/', $asking_class))
		{
			return true;
		}
		if($asking_class == "Evan\Events\Master") {
			return true;
		}
		if($alias == "event_master") {
			return true;
		}
		if(isset($permissions[$method][$alias])){
			if(in_array($asking_class, $permissions[$method][$alias])) {
				return true;
			}
		}
		throw new \Evan\Exception\Exception($asking_class . ": The container refuse to give grant access to " . $alias);

		return false;
	}

};