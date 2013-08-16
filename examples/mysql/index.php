<?php

/****
 * This file assumes you have a database called 'test' on localhost with a user of root and no password
 * 
 * It also assumes you hae a table called 'testtable1' with two columns: id and data
 * You can import database.sql into your mysql server. This will create a database called test.
 * Or, you can just copy the table data into your own database.
 */

require('../../src/Yap.php');

$mysql = yap('YapMySQL'); //initialize mysql engine

$mysql->activate('test', 'localhost', 'root', ''); //activate your mysql connection

$mysql->run('INSERT INTO testtable1(data) VALUES(:d)', array(':d' => 'Insert DATA')); //insert new data
echo 'Last Inserted ID: '.$mysql->lastId(); //get last inserted id

echo '<br/><br/>';

echo 'Selecting One Row: <br />';
var_dump($mysql->one('SELECT * FROM testtable1 WHERE id=:id', array(':id' => rand(1, $mysql->lastId())))); //get a random record
echo '<br/><br/>';
echo 'Selecting Many Rows: <br/>';
var_dump($mysql->many('SELECT * FROM testtable1 WHERE id>10')); //get everything where the id is larger than 10
echo '<br/><br/>';
echo 'Selecting Entire Table: <br />';
var_dump($mysql->all('testtable1')); //get the entire table
