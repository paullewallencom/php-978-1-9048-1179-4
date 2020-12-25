<?php

require_once 'Date/Holidays.php';

$driver   = Date_Holidays::factory('Christian', 2005);
$date     = '2005-05-05';

// no multiple return-values 
$holiday  = $driver->getHolidayForDate($date);
if (! is_null($holiday)) {
  echo $holiday->getTitle();
}

echo "\n"; // debug

// uses multiple return-values 
$holidays = $driver->getHolidayForDate($date, null, true);


print_r($holidays); // debug


if (! is_null($holidays)) {
  foreach ($holidays as $holiday) {
    echo $holiday->getTitle(); 
  }
}

echo "\n"; // debug

?>
