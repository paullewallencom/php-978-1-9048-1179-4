<?php

require_once 'Date.php';
require_once 'Date/Span.php';

$date = new Date('2005-12-01');

// find first Sunday
while ($date->getDayOfWeek() != 0) {
  $date = $date->getNextDay();
}

// advance to second Sunday
$date->addSpan(new Date_Span('7,00:00:00'));
echo $date->getDate();

?>
