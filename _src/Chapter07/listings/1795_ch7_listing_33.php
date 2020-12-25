<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Month.php';
require_once 'Calendar/Day.php';

$month = new Calendar_Month(2005, 12); // December 2005
$month->build(); // builds the contained day objects

// iterate over the fetched day-objects
while ($day = $month->fetch()) {
  echo $day->getTimestamp() . "\n";
}

?>
