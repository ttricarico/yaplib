<?php
require_once "../src/Router.php";

class RouterTest extends PHPUnit_Framework_TestCase {

  public static function callback() {
    return "Hello";
  }

  public function testRouter()  {
    $router = new Router();
    $this->assertEquals(0, count($router->getRouteTable()), "Invalid Route Table");
    $router->get('/', array('RouterTest','callback'));
    $this->assertEquals(1, count($router->getRouteTable()), "Invalid Route Table");
  }
  public function testGet() {
    $router = new Router();
    $router->get('/', array('RouterTest','callback'));
    $data = $router->run('/', Router::httpGet);
    $this->assertEquals("Hello",$data, "HTTP GET return failed");
  }
  /**
   * @expectedException Exception
   */
  public function testException() {
    $router = new Router();
    $router->run('/asjdhasd', Router::httpGet);
  }
  public function testPrivateRoutes() {
    $router = new Router();
    $this->assertNotSame($router->getRouteTable(), $router->getRouteTable());
  }

} 
