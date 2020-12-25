<?php

require_once 'Date/Holidays.php';

$driver = Date_Holidays::factory('Christian', 2005);
if($driver->isHoliday(new Date('2005-09-09'))) {
  echo 'Oh happy day!';
} else {
  echo 'At least it is my birthday.';
}

?>
