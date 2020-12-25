<?php

require_once 'Date.php';

$dates   = array();
$dates[] = new Date('2005-12-24');
$dates[] = new Date('2005-11-14');
$dates[] = new Date('2006-01-04');
$dates[] = new Date('2003-02-12');

usort($dates, array('Date', 'compare'));


// ---- debug output ----
dump($dates);
echo "\n";

function dump($array) 
{
  foreach ($array as $date) {
    echo $date->getDate() . "\n";
  }
}

?>
