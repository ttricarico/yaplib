<?php
require_once "../src/Yap.php";

class YapTest extends PHPUnit_Framework_TestCase {

  public function testLoader()  {
    $yap = new Yap('../src/');
    $yap->load('Router');
    $router = new Router();
    $this->assertEquals(0, count($router->getRouteTable()), "Router was not loaded");
  }

} 
