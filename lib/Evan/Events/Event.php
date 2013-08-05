<?php

namespace Evan\Events;

class Event implements EventInterface
{
	protected $propagation = true;	

	public function stopPropagation()
	{
		$this->propagation = false;
	}

	public function getPropagation()
	{
		return $this->propagation;
	}

}