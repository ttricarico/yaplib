<?php
include_once('../../src/Yap.php');

function helloworld() {
  echo "hi\n";
}

$router = yap('YapRouter');

$router->get('/', 'helloworld');

print_r($router->getRouteTable());
echo count($router->getRouteTable());

echo "\n\n";
$router->run();
echo "\n";

yap()->end();
