<?php

use Evan\Request\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Parser as YamlParser;

require_once("../vendor/autoload.php");

$app = New \Pimple();

// Request processing 
$app['request'] = $app->share(function ($app) {
    return new Request();
});

// Routing Processor
$app['config_routing_file'] = __DIR__. '/config/routing.yml';
$app['routes'] = $app->share(function ($app) {
	$route_yml = new Yaml();
	$route_parsed = $route_yml->parse($app['config_routing_file']);
	return $route_parsed;
});