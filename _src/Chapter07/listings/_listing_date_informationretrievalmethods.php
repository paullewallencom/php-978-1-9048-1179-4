<?php

require_once 'Date.php';

$date = new Date('2005-12-24 09:30:00');

echo 'getDayName(): ' . $date->getDayName() . "\n";
echo 'getDayOfWeek(): ' . $date->getDayOfWeek() . "\n";
echo 'getDaysInMonth(): ' . $date->getDaysInMonth() . "\n";
echo 'getQuarterOfYear(): ' . $date->getQuarterOfYear() . "\n";
echo 'getWeekOfYear(): ' . $date->getWeekOfYear() . "\n";
echo 'getWeeksInMonth(): ' . $date->getWeeksInMonth() . "\n";
echo 'isLeapYear(): ' . "\n"; var_dump($date->isLeapYear(), 1);

?>
