<?php

class YapHeader implements HeaderInterface {

  public static $httpCodes = array(200 => 'OK',
																	 302 => 'Redirect',
                                   307 => 'Temporary Redirect',
                                   400 => 'Bad Request',
                                   401 => 'Unauthorized',
                                   403 => 'Forbidden',
                                   404 => 'Not Found',
                                   420 => 'Enhance Your Calm',
                                   500 => 'Internal Server Error');

  public static $contentTypes = array('text' => 'text/plain',
                                      'html' => 'text/html',
                                      'javascript' => 'application/javascript',
                                      'json' => 'application/json');

  private $httpCode, $contentType;
  private $otherHeaders = array();
  private $instance = null;


  public function __construct() {
    $this->httpCode = 200;
    $this->contentType = YapHeader::$contentTypes['html'];
    $this->instance = md5(mt_rand());
  }

  public function sendHeaders() {
    header('HTTP/1.1 '.$this->httpCode.' '.YapHeader::$httpCodes[$this->httpCode]);
    if(!is_null($this->contentType))
      header('Content-Type: '.$this->contentType);

		foreach($this->otherHeaders as $h) {
      header($h);
    }
  }

  public function redirect($redirectUrl) {
    $this->httpCode = 302;
    $this->contentType = null;
    $this->otherHeaders[] = 'Location: '.$redirectUrl;
    $this->sendHeaders();
    exit();

  }

  public function setContentType($type) {
    $this->contentType = $type;
  }

  public function setCustomHeader($header) {
    $this->otherHeaders[] = $header;
  }

  public function setHTTPCode($code) {
  	$this->httpCode = $code;
  }
}
