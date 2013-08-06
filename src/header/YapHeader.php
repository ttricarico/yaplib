<?php

class YapHeader implements HeaderInterface {
	
	private static $httpCodes = array('200' => 'OK',
																		'401' => 'Unauthorized',
																		'403' => 'Forbidden',
																		'404' => 'Not Found',
																		'420' => 'Enhance Your Calm',
																		'500' => 'Internal Server Error');
																		
	private static $contentTypes = array('text' => 'text/plain',
																			 'html' => 'text/html',
																			 'javascript' => 'application/javascript',
																			 'json' => 'application/json');
	
	public static function sendHTTPResponse($code) {
		header('HTTP/1.1 '.$code.' - '. self::$httpCodes[$code]);
	}
	public static function sendContentType($type) {
		header('Content-Type:'.$contentTypes[$type]);
	}
	public static function sendCustomHeader($header) {
		header($header);
	}
	
}
