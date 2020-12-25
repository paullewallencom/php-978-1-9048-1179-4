<?php

require_once 'Date/TimeZone.php';

$validIDs = Date_Timezone::getAvailableIDs();
print_r($validIDs); // debug

// create a specific TZ
$tz1 = new Date_Timezone('Europe/London');
echo $tz1->getID();

echo "\n"; // debug

// invalid TZ
$tz2 = new Date_Timezone('Something/Invalid');
echo $tz2->getID();

echo "\n"; // debug

// system's default TZ
$default = Date_Timezone::getDefault();
echo $default->getID();

echo "\n"; // debug

?>
