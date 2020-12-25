<?php

require_once 'Date.php';

$now = new Date();
  
$iso8601 = new Date('2005-12-24 12:00:00');
$mysqlTS = new Date('20051224120000');
$unixTS  = new Date(mktime(12, 0, 0, 12, 24, 2005));
$dateObj = new Date($unixTS);




// ---- debug output ----
echo '$now: ' .  $now->getDate() . "\n";
echo '$iso8601: ' .  $iso8601->getDate() . "\n";
echo '$mysqlTS: ' .  $mysqlTS->getDate() . "\n";
echo '$unixTS: ' .  $unixTS->getDate() . "\n";
echo '$dateObj: ' .  $dateObj->getDate() . "\n";

?>
