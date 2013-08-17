<?php

namespace Evan\Controller;

use Evan\Request\Request;
use Evan\Container\ContainerAccess;

class Controller extends ContainerAccess
{

	public function routenotFound404(Request $request)
	{

		echo $this->get('twig')->render('notfound.html.twig', array(
			'request' => $this->get('request'),
            'memory_usage' => \Evan\Tools\Tools::computer_size_convert(memory_get_usage(false)),
            'memory_peak' => \Evan\Tools\Tools::computer_size_convert(memory_get_peak_usage(false)),
			'execution_time' => $this->get('time'),
			'events_triggered' => $this->get('event_master')->getEventsTriggered(),
			'route_schema' => $this->get('routing_schema'),
			'message' => "Route not found",
            'all_queries' => $this->get('queries_collector')->getQueries()
			)
		);

	}
}