<?php

class YapHTTP {
		
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	/** not implemented
	const HEAD = 'HEAD'; 
	const OPTIONS = 'OPTIONS';
	**/
	
	private $ch;
	private $url;
	private $options = array();
	private $method;
	
	
	/**
	 * $option = array( array({curl option}, {option value}),....)
	 */
	public function __construct($url, $method = self::GET, $options = array(), $return = true) {
		$this->ch = curl_init();
		if(!empty($options)) {
			$this->options = $options;
			foreach($this->options as $o) {
				curl_setopt($this->ch, $o[0], $o[1]);
			}
		}
		if($return) {
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		}
		else {
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, false);
		}
		$this->url = $url;
		$this->method = $method;
		
		return $this->ch;
	}
	
	public function setMethod($method = false) {
		if(!$method) {
			throw new Exception('Must define an HTTP method (get, post, put, delete)');
		}
		$this->method = $method;
	}
	public function setUrl($url = false) {
		if(!$url) {
			throw new Exception('Must define a url');
		}
		$this->url = $url;
	}
	
	public function execute() {
		
		curl_setopt($this->ch, CURLOPT_URL, $this->url);
		$this->setCURLMethod();
    
	}
	
	private function setCURLMethod() {
		if($this->method == self::GET) {
      curl_setopt($this->ch, CURLOPT_HTTPGET, true);
		}
		elseif($this->method == self::POST) {
      curl_setopt($this->ch, CURLOPT_POST, true);
		}
		elseif($this->method == self::PUT) {
      curl_setopt($this->ch, CURLOPT_PUT, true);
		}
    elseif($this->method == self::DELETE) {
      curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
    else {
      throw new Exception('Unknown HTTP method, use YapHTTP:GET, YapHTTP:POST, YapHTTP:PUT, or YapHTTP:DELETE');
    }
	}
  
  public static function get($url) {
    $stream = stream_context_create(array(
                                        'http' => array('method'=>'GET')
                                        )
                                   );
    $file = file_get_contents($url, false, $stream);
    return $file;
  }
  public static function post($url,$data) {
    $stream = stream_context_create(array(
                                        'http' => array('method'=>'POST'),
                                        'content' => http_build_query($data))
                                   );
    $file = file_get_contents($url, false, $stream);
    return $file;
  }
  public static function put($url) {
    $stream = stream_context_create(array(
                                        'http' => array('method'=>'PUT')
                                        )
                                   );
    $file = file_get_contents($url, false, $stream);
    return $file;
  }
  public static function delete($url) {
    $stream = stream_context_create(array(
                                        'http' => array('method'=>'DELETE')
                                        )
                                   );
    $file = file_get_contents($url, false, $stream);
    return $file;
  }
}
