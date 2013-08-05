<?php

class SessionTest extends PHPUnit_Framework_TestCase {

  // need to determine a way to test sessions without using
  // webserver version of php.  might not be needed.
  public function testSession()  {
    $this->assertEquals(1,1);
  }

} 
