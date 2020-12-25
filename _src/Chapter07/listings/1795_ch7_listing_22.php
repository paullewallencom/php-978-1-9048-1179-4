<?php

require_once 'Date/Holidays.php';

$driver  = Date_Holidays::factory('Christian', 2005);
$holiday = $driver->getHoliday('easter');
$title   = $driver->getHolidayTitle('easter');
$date    = $driver->getHolidayDate('easter');


// --- debug output ---
print_r($holiday);
var_dump($title);
print_r($date);
echo $date->getDate();
?>
