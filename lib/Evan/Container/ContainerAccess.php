<?php

namespace Evan\Container;

class ContainerAccess
{
	private $container;


	public function __construct(Container &$container)
	{
		$this->container = &$container;
	}

	final protected function get($alias) {
			$asking_class = get_called_class();
		return $this->container->get($alias, $asking_class);
	}

	final protected function set($alias, $value) {
			$asking_class = get_called_class();
		return $this->container->set($alias, $asking_class, $value);
	}
}