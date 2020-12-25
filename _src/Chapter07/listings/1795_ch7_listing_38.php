<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Month.php';
require_once 'Calendar/Day.php';

$month = new Calendar_Month(2005, 12);

$stNicholas = new Calendar_Day(2005, 12, 6);
$xmasEve    = new Calendar_Day(2005, 12, 24);

$selection  = array($stNicholas, $xmasEve);
$month->build($selection); 

while ($day = $month->fetch()) {
  if ($day->isSelected()) {
    echo $day->getTimestamp() . "\n";
  }
}

?>
