<?php

namespace Evan\Events;


use Evan\Container\ContainerAccess;

class Master extends ContainerAccess
{

	protected $event_listeners = array();
	protected $events_triggered = array();


	function triggerEvent(EventInterface $event, $alias)
	{
		$this->events_triggered[] = array(
			'alias' =>$alias,
			'event' => get_class($event)
			);
		if(array_key_exists($alias, $this->event_listeners)) {
			foreach($this->event_listeners[$alias] as $listener_alias => $callback) {
				if(is_null($this->get($listener_alias))) {
					throw new \Evan\Exception\Exception(get_class($this) . ": The container refuse to give grant access to " . $listener_alias);

				}
				$event = $this->get($listener_alias)->$callback($event);
				if($event->getPropagation() == false) {
					break;
				}
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