<?php
include_once('../../src/Yap.php');
$yap = new Yap('../../src/');
$yap->load('Router');

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
