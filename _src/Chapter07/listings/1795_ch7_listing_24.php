<?php

require_once 'Date/Holidays.php';
require_once 'Date/Holidays/Filter/Composite.php';

$driver    = Date_Holidays::factory('Christian', 2005);

$filter1   = new Date_Holidays_Filter_Whitelist(
    array('goodFriday', 'easter'));
$filter2   = new Date_Holidays_Filter_Whitelist(
    array('easterMonday'));

$composite = new Date_Holidays_Filter_Composite();
$composite->addFilter($filter1);
$composite->addFilter($filter2);
    
$holidays  = $driver->getHolidays($composite);
echo count($holidays);


// --- debug output ---
print_r($holidays);

?>
