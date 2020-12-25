<?php

// Switch to PEAR::Date engine
define('CALENDAR_ENGINE', 'PearDate');

require_once 'Calendar/Second.php';

$second = new Calendar_Second(2005, 12, 24, 20, 30, 40);

echo $second->nextDay('int') . "\n";
echo $second->nextDay('timestamp') . "\n";
print_r( $second->nextDay('object') );
print_r( $second->nextDay('array') );

?>
