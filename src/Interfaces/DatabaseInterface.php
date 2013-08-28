<?php

interface DatabaseInterface {
  public function all($table);
  public function one($query, $params);	//select one row
  public function many($query, $params); //select many rows
  public function run($query, $params);	// execute insert/update, etc
  public function lastId(); //retrieve last inserted id
}
