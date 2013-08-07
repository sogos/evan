<?php


require_once("../app/Kernel.php");
ini_set('xdebug.max_nesting_level', 300);

// $app['time'] = function ($app) {
// 	return (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]);
// };

try {

	$app['request']->handle();

} catch(\Exception $e) {
	echo "<pre>";
	echo $e->getMessage();
}
