<?php
require_once "../src/Yap.php";

class RouterTest extends PHPUnit_Framework_TestCase {

  protected function setUp()  {
    $yap = new Yap("../src/");
    $yap->load('Router');
  }

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
    $this->assertSame($router->getRouteTable(), $router->getRouteTable());
    $table = $router->getRouteTable();
    $table['hi']='hi';
    $this->assertNotSame($table, $router->getRouteTable());
    $this->assertCount(0, $router->getRouteTable());
  }

  public function testYapSingleton()  {
    $router = yap('Router');
    $this->assertEquals(0, count($router->getRouteTable()), "Invalid Route Table");
  }

} 
