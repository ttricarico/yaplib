<?php
ini_set('display_errors', 1);

include_once('../../src/Yap.php');

$session = yap('YapSession');

if($session->get('counter')) 
	$counter = $session->get('counter') + 1;

else
	$counter = 1;

$session->set('counter', $counter);


echo $session->get('counter');
