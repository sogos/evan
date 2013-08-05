<?php


function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

require_once("../app/Kernel.php");


$app['time'] = function ($app) {
	return (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]);
};

$result = $app['request']->handle();


