<?php
/**
 * This is a very simple templating class. All it does is loads up your specified html and delivers it to the screen. The most
 * advanced thing it does is load a predefined html header and footer.
 */

class YapTemplate{
	  
	const SIMPLE = 1;
  const ADVANCE = 2;
	private $view;
	private $instance;
	private $header = null; //for websites where every header and footer page are the same, 
  private $footer = null; //so you dont have to constantly put $obj->display({header}) and $obj->display({footer})
  private $type;
	
  
	public function __construct() {
		$this->instance = md5(mt_rand(0, getrandmax()));
    $this->type = self::SIMPLE;
	}
	public function setDirectory($d){
		$this->view =  $d;
	}
  public function display($template = null, $vars = array(), $loadheader = false, $loadfooter = false) {
    if(!empty($vars)) {
			extract($vars);
		}
    
    $temp = $this->view . DIRECTORY_SEPARATOR . $template;
    if(is_file($temp)) {
      if($loadheader)
        $this->loadPageHeader($vars);
      include($temp);
      if($loadfooter)
        $this->loadPageFooter($vars);
    }
    else {
      throw new Exception('Failed loading template: '.$temp.'. File does not exist in '.$this->view);
    }
	}
  
  public function setPageHeader($template) {
    $this->header = $template;
  }
  public function setPageFooter($template) {
    $this->footer = $template;
  }
  public function loadPageHeader($vars = array()) {
    $this->display($this->header, $vars);
  }
  public function loadPageFooter($vars = array()) {
    $this->display($this->footer, $vars);
  }
  
  public function setTemplateType($type) {
    $this->type = $type;
  }
}
