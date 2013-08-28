<?php

class YapCookie implements CookieInterface {

  private $path;
  private $domain;
  private $secure = false;
  private $httponly = true;

  public function __construct() {
    if(func_num_args() < 3) 
      throw new Exception('Not enough parameters to create cookie. You need at least two ($path, $domain)');
  
    $this->path = func_get_arg(0);
    $this->domain = func_get_arg(1);
  
    if(isset(func_get_arg(2)))
      $this->secure = func_get_arg(2);
	
    if(isset(func_get_arg(3)))
      $this->httponly = func_get_arg(3);		
  }

  public function set($name, $value, $expiretime = 0) {
    if(func_num_args() < 3)
      throw new Exception('You must have at least two parameters ($name, $value)');
 
    setcookie($name, $value, $expiretime, $this->path, $this->domain, $this->secure, $this->httponly);
  }

  public function delete($name) {
    setcookie($name, null, 946684800); //set to expire on January 1, 2000
  }

  public function get($name) {
    if(isset($_COOKIE[$name]))
      return $_COOKIE[$name];
    else
      return false;
  }

  public function deleteAll() {
    foreach($_COOKIE as $key=>$value) {
      setcookie($key, null, 946684800);
    }
  }
}
