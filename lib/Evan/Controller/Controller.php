<?php

namespace Evan\Controller;

use Evan\Request\Request;
use Evan\Container\ContainerAccess;

class Controller extends ContainerAccess
{

	public function routenotFound404(Request $request)
	{

		echo $this->container->get('twig')->render('notfound.html.twig', array(
			'request' => $this->container->get('request'),
			'memory_usage' => convert(memory_get_usage(false)),
			'memory_peak' => convert(memory_get_peak_usage(false)),
			'execution_time' => $this->container->get('time'),
			'events_triggered' => $this->container->get('event_master')->getEventsTriggered(),
			'route_schema' => $this->container->get('routing_schema'),
			'message' => "Route not found"
			)
		);

	}
}