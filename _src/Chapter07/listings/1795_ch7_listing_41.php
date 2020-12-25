<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Day.php';

$day = new Calendar_Day(2005, 13, 32);

if (! $day->isValid()) {
  $validator = $day->getValidator();
  while ($error = $validator->fetch()) {
    echo sprintf("Invalid date: unit is %s, value is %s. Reason: %s \n",
        $error->getUnit(),
        $error->getValue(),
        $error->getMessage());
  }
}

?>
