<?php

require_once 'Calendar/Day.php';

$day = new Calendar_Day(2005, 12, 24);

echo $day->thisYear();
echo $day->thisMonth();
echo $day->thisDay();
echo $day->thisHour();
echo $day->thisMinute();
echo $day->thisSecond();


// ------ debug output ------
echo "\n\n";
echo $day->thisYear()   . "\n";   // prints: 2005
echo $day->thisMonth()  . "\n";   // prints: 12
echo $day->thisDay()    . "\n";   // prints: 24
echo $day->thisHour()   . "\n";   // prints: 0
echo $day->thisMinute() . "\n";   // prints: 0
echo $day->thisSecond() . "\n";   // prints: 0

?>
