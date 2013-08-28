<?php

class YapMySQL implements DatabaseInterface {

  private $name, $host, $user, $password;
  private $db;
  private $instance;
  private $activated;
	
  public function __construct() {
    $this->instance = sha1(mt_rand(0, mt_getrandmax()));
    $this->activated = $this->instance;
    return $this->instance; 
  }
  
  public function activate() {
    if($this->activated === true) {
      return $this->activated;
    }
    else {
      if(func_num_args() < 4) {
        throw new Exception('Not enough arguments to create a MySQL connection');
      }
      else {
        $this->name = func_get_arg(0);
        $this->host = func_get_arg(1);
        $this->user = func_get_arg(2);
        $this->password = func_get_arg(3);
        
        try{
          $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->name, $this->user, $this->password);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->activated = true;
          return true;
        }catch(Exception $e) {
          throw new Exception('Could not connect to database, PDO says: '.$e);
        } 
      }
    }
  }
	
  // returns a single row
  public function one($query, $params = array()) {
    try {
      $p = $this->prepare($query, $params);
        return $p->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
      throw new Exception('Query error. PDO says: '.$e->getMessage().' | Your query: '.$query);
      return false;
    }
  }

  //returns many rows
	public function many($query, $params = array()) {
		try {
      $p = $this->prepare($query, $params);
      return $p->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
      throw new Exception('Query error. PDO says: '.$e->getMessage().' | Your query: '.$query);
      return false;
    }
	}
  /**
   * @param $table = table name
   * @return entire table
   */
  public function all($table) {
    try {
      return $this->many('SELECT * FROM '.$table.' WHERE 1');
    }
    catch(Exception $e) {
      throw new Exception('Query error. PDO says: '.$e->getMessage().' | Your query: '.$query);
      return false;
    }
  }
	
  //runs a query, such as INSERT, DELETE, or UPDATE
  public function run($query, $params = array()) {
    try{
      $p = $this->prepare($query, $params);
      if(preg_match('/insert/i', $query))	//if inserted row, return inserted id
        return $this->db->lastInsertId();
      else 		//otherwise return number of affected rows
        return $p->rowCount();
    }catch(Exception $e) {
      throw new Exception('Query error. PDO says: '.$e->getMessage().' | Your query: '.$query);
      return false;
    }
  }
	
  public function lastId() {
    $id = $this->db->lastInsertId();
    if($id > 0) {
      return $id;
    }
    else {
  	  return false;
    }
  }
	
  /** prepare query for mysql
   * @param $query
   * @param $params
   * @return $p
   */
  private function prepare($query, $params = array()) {
    try {
      $p = $this->db->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $p->execute($params);
      return $p;
    }catch(Exception $e) {
      throw new Exception('Query error. PDO says: '.$e->getMessage().' | Your query: '.$query);
    }
  } 
}
