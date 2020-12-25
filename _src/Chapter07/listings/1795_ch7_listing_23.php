<?php

require_once 'Date/Holidays.php';

$driver     = Date_Holidays::factory('Christian', 2005);

echo count($driver->getHolidays());

echo "\n"; // debug

$whitelist  = new Date_Holidays_Filter_Whitelist(
    array('goodFriday', 'easter', 'easterMonday'));
$wlHolidays = $driver->getHolidays($whitelist);
echo count($wlHolidays);

echo "\n"; // debug

$blacklist  = new Date_Holidays_Filter_Blacklist(
    array('goodFriday', 'easter', 'easterMonday'));
$blHolidays = $driver->getHolidays($blacklist);
echo count($blHolidays);


echo "\n"; // debug


?>
