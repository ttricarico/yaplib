<?php

class YapHTTP {
    
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
  
  
  public function __construct() {
    $this->ch = curl_init();
  }
  
  public function __destruct() {
    curl_close($this->ch);
  }
  
  public function setUrl($url) {
    $this->url = $url;
  }
  /**
   * $option = array( array({curl option}, {option value}),....)
   */
  public function addOption($option = array()) {
    $this->options = array_merge($this->options, $option);
    return $this->options;
  }
  public function setReturn($return) {
    $this->return = $return;
  }
  private function setOptions() {
    foreach($this->options as $o)
    curl_setopt($this->ch, $o[0], $o[1]);
  }
  private function execute() {
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    try{
      $data = curl_exec($this->ch);
    }catch(Exception $e) {
      //see if the url has https, if so try again with an added option
      if(preg_match('^(http|https)://', $this->url)) {
        //yes, i know this is dangerous
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        try{
          $data = curl_exec($this->ch);
        }catch(Exception $e) {
          //well, it didnt work, so just return false
          $data = false;
          //OR THROW AN EXCEPTION!
          throw new Exception('Get Failed, Curl Response: '.$e->getMessage());
        }
      }
      throw new Exception('Get Failed, Curl Response: '.$e->getMessage());
      $data = false;
    }
    
    if($this->return)
      return $data;
    else
      echo $data;
  }
  public function get($dataToSend = null) {
    if($dataToSend != null) {
      $queryString = http_build_query($dataToSend);
      curl_setopt($this->ch, CURLOPT_URL, $this->url.'?'.$queryString);
    }
    else{
      curl_setopt($this->ch, CURLOPT_URL, $this->url);
    }
    
    
    $this->setOptions();
    curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, self::GET);

    
    return $this->execute();
  }
  public function post($dataToSend = null) {
    if($dataToSend != null) {
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, $dataToSend);
    }
    
    curl_setopt($this->ch, CURLOPT_URL, $this->url);
    $this->setOptions();
    curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, self::POST);
    
    return $this->execute();
  }


}
