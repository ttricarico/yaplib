<?php
include_once('../../src/Yap.php');

yap('YapEnv')->setDev();
doIt();
yap('YapEnv')->setPro();
doIt();

function doIt() {
  echo "====================\nCurrent Mode: ";
  echo yap('YapEnv')->getMode() . "\n";
  $thing['Hello'] = "Some data";
  echo "\n";
  echo $thing[Hello]; // this should generate a warning if in development
  echo "\n====================\n";
}


