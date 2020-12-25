<?php

require_once 'Date/Holidays.php';

$driver   = Date_Holidays::factory('Christian', 2005);
if ($driver->isHoliday('2005-05-05')) {
  echo 'It is a holiday!';
} else {
  echo 'It is not a holiday!';
}

?>
