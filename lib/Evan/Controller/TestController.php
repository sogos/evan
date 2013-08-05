<?php

namespace Evan\Controller;

use Evan\Request\Request;

class TestController extends Controller
{

	public function index(Request $request, $toto = null)
	{

		echo $this->app['twig']->render('test.html.twig', array(
			'request' => $this->app['request'],
			'memory_usage' => convert(memory_get_usage(false)),
			'memory_peak' => convert(memory_get_peak_usage(false)),
			'execution_time' => $this->app['time'],
			'events_triggered' => $this->app['event_master']->getEventsTriggered(),
			'route_schema' => $this->app['routing_schema'],
			'toto' => $toto
			)
		);

	}



}