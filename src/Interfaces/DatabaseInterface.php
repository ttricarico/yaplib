<?php

interface DatabaseInterface {
	public function one();	//select one row
	public function many(); //select many rows
	public function execute();	// execute insert/update, etc
	public function lastId(); //retrieve last inserted id
}
