<?php

require_once 'Date.php';

$date = new Date('2005-12-24 09:30:00');

$prev   = $date->getPrevDay();
$prevWd = $date->getPrevWeekday();

$next   = $date->getNextDay();
$nextWd = $date->getNextWeekday();



// ---- debug output ----

echo 'Date: ' . $date->getDate() . "\n";

echo 'Prev: ' . $prev->getDate() . "\n";
echo 'Prev weekday: ' . $prevWd->getDate() . "\n";


echo 'Next: ' . $next->getDate() . "\n";
echo 'Next weekday: ' . $nextWd->getDate() . "\n";


?>
