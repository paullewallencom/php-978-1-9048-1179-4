<?php

require_once 'Date.php';
require_once 'Date/TimeZone.php';

$date = new Date('2005-12-24 12:00:00');
$date->setTZbyID('Europe/Berlin');
echo $date->getDate();

echo "\n"; // debug


$date->convertTZbyID('Europe/London');
echo $date->getDate();


echo "\n"; // debug

var_dump($date->inDaylightTime()); // debug

?>
