<?php

require_once 'Date/Holidays.php';
$driverId = 'Christian';
$year     = 2005;
$locale   = null;

$driver        = Date_Holidays::factory($driverId, $year, $locale);
$internalNames = $driver->getInternalHolidayNames();

print_r($internalNames);
?>
