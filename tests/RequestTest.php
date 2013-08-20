<?php
require_once "../src/Yap.php";

class RequestTest extends PHPUnit_Framework_TestCase {

  public function testHTTPGET()  {
    $api = "http://api.openweathermap.org/data/2.5/weather";
    $q = array('q'=>'Tallahassee,FL');
    yap('YapRequest')->setURL($api);
    $data = yap('YapRequest')->get($q);
    $data = json_decode($data);
    $this->assertEquals($data->name, "Tallahassee");
  }

} 
