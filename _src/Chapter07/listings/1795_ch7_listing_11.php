<?php

require_once 'Date/Span.php';

$tspans   = array();
$tspans[] = new Date_Span('1, 12:33:02');
$tspans[] = new Date_Span('1, 00:33:02');
$tspans[] = new Date_Span('3, 00:00:00');
$tspans[] = new Date_Span('1');

usort($tspans, array('Date_Span', 'compare'));


// --- debug output ---
dump($tspans);

function dump($array) 
{
  foreach ($array as $span) {
    echo $span->toDays() . " days\n";
  }
}

?>
