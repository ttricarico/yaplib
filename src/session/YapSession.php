<?php
class YapSession implements SessionInterface {
  private $session;
  private $testmode = false;
  function __construct() {
    if(!session_id()) {
      session_start();
    }
    $this->session = &$_SESSION;
  }
  
  public function get($key) {
    if(empty($this->session[$key]))
      return false;
    else
      return $this->session[$key];
  }
  public function set($key, $value) {
    $this->session[$key] = $value;
    return $value;
  }
  public function delete($key) {
    if(!isset($this->session[$key]))
      return false;
  	
    unset($this->session[$key]);
  }
  public function end() {
    if($this->testmode === false) {
      session_destroy();
    }
    else {
      unset($this->session);
    }
  }
  public function checkIfExists($key) {
    if(isset($this->session[$key])) 
      return true;
    else
      return false;
  }
}