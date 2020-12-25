<?php

require_once 'Calendar/Day.php';

$day = new Calendar_Day(2005, 13, 32);

if (! $day->isValid()) {
  echo "Day's date is invalid! \n";
  
  // more fine grained validation
  $validator = $day->getValidator();
  
  if (! $validator->isValidDay()) {
    echo "Invalid day unit: " . $day->thisDay() . "\n";
  }
  if (! $validator->isValidMonth()) {
    echo "Invalid month unit: " . $day->thisMonth() . "\n";
  }
  if (! $validator->isValidYear()) {
    echo "Invalid year unit: " . $day->thisYear() . "\n";
  }
}

?>
