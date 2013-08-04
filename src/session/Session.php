<?php

class YapSession {

	const SESSION_COOKIE = 'YapSession';
	const PHP = 'PHP';
	/** NOT YET IMPLEMENTED **/
	//const Memcached = 'Memcached';
	//const APC = 'APC';
	
	private static $SessionFile;
	private static $SessionMethod;
	private static $SessionInstance;
	
	function __construct() {
		session_start();
	}
	
	public function get($key) {
		if(empty($_SESSION[$key]) || !isset($_SESSION[$key]))
			return false;
		else
			return $_SESSION[$key];
	}
	public function set($key, $value) {
		$_SESSION[$key] = $value;
		return $value;
	}
	public function delete($key) {
		if(!isset($_SESSION[$key]))
			return false;
		
		unset($_SESSION[$key]);
	}
	public function end() {
		session_destroy();
	}
	
	
	
	// get the singleton instance
	public static function getInstance() {
		if($SessionFile == 'SessionPHP.php') {
			if(!$SessionInstance) {
				$SessionInstance = new YapSession(self::PHP);
				return $SessionInstance;
			}
			else {
				return $SessionInstance;
			}
		}
		else {
			throw new Exception('Unable to load sessionizer');
		}
	}
}

interface YapSessionInterface {
	public function get($key);
	public function set($key, $value);
	public function delete($key);
	public function end($key);
}

function getSession() {
	return YapSession::getInstance();
}
