<?php
require_once "../src/Yap.php";

class RouterTest extends PHPUnit_Framework_TestCase {

  protected function setUp()  {
    $yap = new Yap("../src/");
    $yap->load('YapRouter');
  }

  protected function tearDown() {
    unset($yap);
  }

  public static function callback() {
    return "Hello";
  }

  public function testRouter()  {
    $router = new YapRouter();
    $this->assertEquals(0, count($router->getRouteTable()), "Invalid Route Table");
    $router->get('/', array('RouterTest','callback'));
    $this->assertEquals(1, count($router->getRouteTable()), "Invalid Route Table");
  }
  public function testGet() {
    $router = new YapRouter();
    $router->get('/', array('RouterTest','callback'));
    $data = $router->run('/', YapRouter::httpGet);
    $this->assertEquals("Hello",$data, "HTTP GET return failed");
  }
  /**
   * @expectedException Exception
   */
  public function testException() {
    $router = new YapRouter();
    $router->run('/asjdhasd', YapRouter::httpGet);
  }
  public function testPrivateRoutes() {
    $router = new YapRouter();
    $this->assertSame($router->getRouteTable(), $router->getRouteTable());
    $table = $router->getRouteTable();
    $table['hi']='hi';
    $this->assertNotSame($table, $router->getRouteTable());
    $this->assertCount(0, $router->getRouteTable());
  }

  public function testYapSingleton()  {
    yap('YapRouter')->get('/', array('RouterTest','callback'));
    $router = yap('YapRouter');
    $this->assertEquals(1, count($router->getRouteTable()), "Invalid Route Table");
  }

} 
