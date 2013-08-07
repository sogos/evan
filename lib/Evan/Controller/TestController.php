<?php

namespace Evan\Controller;

use Evan\Request\Request;
use Evan\Entity\Plop;

class TestController extends Controller
{

	public function index(Request $request, $toto = null)
	{

		$em =$this->get('entityManager');

		// $plop = New Plop();
		// $plop->setTitle("Plop");
		// $plop->setContent("Plok");
		// $em->persist($plop);
		// $em->flush();

		
		$plop_repository = $em->getRepository("Evan\Entity\Plop");
		$all_plop = $plop_repository->findAll();


		echo $this->get('twig')->render('test.html.twig', array(
			'request' => $this->get('request'),
			'memory_usage' => \Evan\Tools\Tools::computer_size_convert(memory_get_usage(false)),
			'memory_peak' => \Evan\Tools\Tools::computer_size_convert(memory_get_peak_usage(false)),
			'execution_time' => $this->get('time'),
			'events_triggered' => $this->get('event_master')->getEventsTriggered(),
			'route_schema' => $this->get('routing_schema'),
			'toto' => $toto,
			'all_plop' => $all_plop
			)
		);

	}



}