<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Month.php';
require_once 'Calendar/Day.php';

$month = new Calendar_Month(2005, 12); // December 2005
$month->build(); 

while ($day = $month->fetch()) {
  echo $day->getTimestamp() . "\n";
}


// --- debug output ---
print_r($month->fetchAll());

?>
