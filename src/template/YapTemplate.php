<?php
class YapTemplate{
  private $view;
  private $instance;	
  
  public function __construct() {
    $this->instance = md5(mt_rand(0, getrandmax()));
  }
  public function setDirectory($d){
    $this->view =  $d;
  }
  public function display($template = null, $vars = array()) {
    if(!empty($vars)) {
      extract($vars);
    }
    
    $temp = $this->view . DIRECTORY_SEPARATOR . $template;
    if(is_file($temp))
      include($temp);
    else 
      throw new Exception('Failed loading template: '.$temp.'. File does not exist in '.$this->view);
  }
}
