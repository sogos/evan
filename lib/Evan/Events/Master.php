<?php

namespace Evan\Events;

class Master
{

	protected $event_listeners = array();
	protected $events_triggered = array();

	function __construct(&$app) {
		$this->app = $app;
	}

	function triggerEvent(EventInterface $event, $alias)
	{
		$this->events_triggered[] = array(
			'alias' =>$alias,
			'event' => get_class($event)
			);
		if(array_key_exists($alias, $this->event_listeners)) {
			foreach($this->event_listeners[$alias] as $listener_alias => $callback) {
				$event = $this->app[$listener_alias]->$callback($event);
			}
		}
		return $event;
	}

	function subscribeToEvent($listener_alias, $eventAlias , $callback ) {
		$this->event_listeners[$eventAlias][$listener_alias] = $callback;

	}

	public function getEventsTriggered()
	{
		return $this->events_triggered;
	}


}