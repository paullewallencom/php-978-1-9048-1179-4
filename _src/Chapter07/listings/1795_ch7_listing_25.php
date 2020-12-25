<?php

require_once 'Date/Holidays.php';

$driver1   = Date_Holidays::factory('Christian', 2005);
echo count($driver1->getInternalHolidayNames());


echo "\n"; // debug


$driver2   = Date_Holidays::factory('UNO', 2005);
echo count($driver2->getInternalHolidayNames());


echo "\n"; // debug 


$composite = Date_Holidays::factory('Composite');
$composite->addDriver($driver1);
$composite->addDriver($driver2);

$holidays  = $composite->getInternalHolidayNames();
echo count($holidays);


// --- debug output ---
echo "\n";
print_r($holidays);
echo count($holidays);
echo "\n";

?>
