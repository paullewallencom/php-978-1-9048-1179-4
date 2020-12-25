<?php

require_once 'Calendar/Year.php';
require_once 'Calendar/Month.php';
require_once 'Calendar/Day.php';
require_once 'Calendar/Hour.php';
require_once 'Calendar/Minute.php';
require_once 'Calendar/Second.php';

require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Month/Weeks.php';
require_once 'Calendar/Week.php';

// date classes
$year   = new Calendar_Year(2005);
$month  = new Calendar_Month(2005, 12);
$day    = new Calendar_Day(2005, 12, 24);
$hour   = new Calendar_Hour(2005, 12, 24, 20);
$minute = new Calendar_Minute(2005, 12, 24, 20, 30);
$second = new Calendar_Second(2005, 12, 24, 20, 30, 40);

// tabular date classes
$firstDay = 0; // Sunday is the first day in the tabular representation
$monthWkD = new Calendar_Month_Weekdays(2005, 12, $firstDay);
$monthWk  = new Calendar_Month_Weeks(2005, 12, $firstDay); 
$week     = new Calendar_Week(2005, 12, 24, $firstDay);



// --- debug output ----
$items = array('year', 'month', 'day', 'hour', 'minute', 'second', 'monthWkD', 'monthWk', 'week');

foreach ($items as $item) {
  var_dump($$item);
  echo "----------------------------\n";
}



?>
