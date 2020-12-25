<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Day.php';

$day = new Calendar_Day(2005, 13, 32);
$day->adjust();

echo $day->getTimestamp();

?>
