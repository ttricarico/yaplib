<?php
require_once "../src/Yap.php";

class EnvironmentTest extends PHPUnit_Framework_TestCase {

  public function testProduction()  {
    yap('YapEnv')->setPro();
    $this->assertEquals(yap('YapEnv')->getMode(), "Production");
  }

  public function testDevelopment()  {
    yap('YapEnv')->setDev();
    $this->assertEquals(yap('YapEnv')->getMode(), "Development");
  }

} 
