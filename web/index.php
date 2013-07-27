<?php

require_once("../app/Kernel.php");

echo "<pre>";
echo $app['request']->getMethod();
echo "<br>";
echo $app['request']->getUri();
echo "<br>";
echo $app['request']->getBrowserLang();
echo "<br>";
var_dump($app['routing']);