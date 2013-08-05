<?php

class Session implements YapSessionInterface {
	
	function __construct() {
		if(!session_id())
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
	
}
