<?php

class YapRequest {
    
  const GET = 'GET';
  const POST = 'POST';
  
  /** not implemented
  const PUT = 'PUT';
  const DELETE = 'DELETE';
  const HEAD = 'HEAD'; 
  const OPTIONS = 'OPTIONS';
  **/
  
  private $ch;
  private $url;
  private $options = array();
  private $return = true;
  private $instance;
  
  
  public function __construct() {
    if(!function_exists('curl_init')) {
      throw new Exception('Curl must be installed to allow http requests. Contact your hosting provider to install curl or install it.');
    }
    $this->instance = md5(mt_rand());
  }  
  public function __destruct() {
    $this->instance = null;
  }
  
  public function setOptions($options = null) {
    if(!is_null($options)) {
      foreach($options as $o) {
        curl_setopt($this->ch, $o[0], $o[1]);
      }
    }
  }
  public function checkSecure($url) {
    if(preg_match('/^https/', $url)) {
      $this->setoptions(array(  //yes, i know this is dangerous
                            array(CURLOPT_SSL_VERIFYPEER, 0),
                            array(CURLOPT_SSL_VERIFYHOST, 0)
      ));
    }
  }
  public function get($url, $dataToSend = array(), $options = null, $return = true) {
    $this->ch = curl_init();
    $this->url = $url.$this->generateQueryString($dataToSend);
	curl_setopt($this->ch, CURLOPT_URL, $this->url);
    $this->setReturn($return);
    $this->setOptions($options);
    $response = curl_exec($this->ch);
    if(!$response) {
      $this->checkSecure($url);
      $response = curl_exec($this->ch);
      if(!$response) {
        throw new Exception('Could not process request, curl responded with: '.curl_error($this->ch));	
      }
    }
	
    curl_close($this->ch);
	return $response;
  }
  public function post($url, $dataToSend = array(), $options = array(), $return = true) {
    $this->setReturn($return);
  }

  /**
   * $dataToSend = array(key => value)
   */
  private function generateQueryString($dataToSend = array()) {
    $temp = '';
    if(!empty($dataToSend)){
      $temp = '?';
      foreach($dataToSend as $k=>$v) {
        if($temp != '?') {
         $temp .= '&'; 
        }
        $temp .= $k.'='.urlencode($v);
      }
    }
    
    return $temp;
  }
  private function generatePostFields($dataToSend = array()) {
    
  }
  private function setReturn($return){
    if($return)
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    else
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, false);
  }
}
