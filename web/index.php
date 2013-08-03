<?php


function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

require_once("../app/Kernel.php");


$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];


$result = $app['request']->handle();

echo $app['twig']->render('index.html.twig', array(
	'request' => $app['request'],
	'memory_usage' => convert(memory_get_usage(false)),
	'memory_peak' => convert(memory_get_peak_usage(false)),
	'execution_time' => $time,
	'events_triggered' => $app['event_master']->getEventsTriggered(),
	'route_schema' => $app['routing_schema']
	)
);

