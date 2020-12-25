<?php

require_once 'Date/Holidays.php';

$driver   = Date_Holidays::factory('Christian', 2005);
$holidays = $driver->getHolidays();
$titles   = $driver->getHolidayTitles();
$dates    = $driver->getHolidayDates();

// --- debug output ---
print_r($holidays);
print_r($titles);
print_r($dates);
?>
