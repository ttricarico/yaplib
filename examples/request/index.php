<?php


require('../../src/Yap.php');

yap('YapRequest', 'http');
yap('YapRouter', 'router');

yap('router')->get('/', 'doGet');
yap('router')->post('/', 'doPost');

yap('router')->run();

function doGet() {
  echo 'getdone'.PHP_EOL;
  yap('http')->setUrl('http://localhost/yaplib');
  echo yap('http')->post();
}
function doPost(){
  echo 'postdone';
}