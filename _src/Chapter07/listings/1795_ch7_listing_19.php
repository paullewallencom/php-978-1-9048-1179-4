<?php

require_once 'Date/Holidays.php';
$driverId = 'Christian';
$year     = 2005;
$locale   = null;

$driver = Date_Holidays::factory($driverId, $year, $locale);
if (Date_Holidays::isError($driver)) {
  die('Creation of driver failed: ' . $driver->getMessage());
} else {
  // ... go on
  echo 'Driver successfully created!';
}

?>
