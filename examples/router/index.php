<?php
include_once('../../src/Router.php');

function helloworld() {
  echo "hi\n";
}

$router = new Router();
 
$router->get('/', 'helloworld');

print_r($router->getRouteTable());
echo count($router->getRouteTable());

echo "\n\n";
$router->run();
echo "\n";
