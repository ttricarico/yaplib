<?php

/****
 * This file assumes you have a database called 'test' on localhost with a user of root and no password
 * 
 * It also assumes you hae a table called 'testtable1' with two columns: id and data
 * You can import database.sql into your mysql server. This will create a database called test.
 * Or, you can just copy the table data into your own database.
 */

require('../../src/Yap.php');

yap('YapMySQL', 'mysql1'); //initialize mysql engine
yap('YapMySQL', 'mysql2');

echo 'mysql1:<br/>';
var_dump(yap('mysql1'));
echo '<br/><br/>mysql2:<br/>';
var_dump(yap('mysql2'));


yap('mysql1')->activate('test', 'localhost', 'root', ''); //activate your mysql connection
yap('mysql2')->activate('test2','localhost', 'root', ''); //activate your mysql connection


var_dump(yap('mysql1')->all('testtable1'));

var_dump(yap('mysql2')->all('testingtothemax'));
