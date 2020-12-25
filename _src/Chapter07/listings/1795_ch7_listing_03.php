<?php

require_once 'Date.php';

$date = new Date('2005-12-24 09:30:00');
echo '$date: ' . $date->getDate() . "\n"; // debug

$copy = new Date();
echo '$copy: ' . $copy->getDate() . "\n"; // debug

$copy->copy($date);
echo '$copy->copy($date): ' . $copy->getDate() . "\n"; // debug

$copy->setHour(12);
echo '$copy->setHour(12): ' . $copy->getDate() . "\n"; // debug
$copy->setMinute(0);
echo '$copy->setMinute(0): ' . $copy->getDate() . "\n"; // debug

$copy->addSeconds(30);
echo '$copy->addSeconds(30): ' . $copy->getDate() . "\n"; // debug

$date->setDate($copy->getDate());
echo '$date->setDate($copy->getDate()): ' . $date->getDate() . "\n"; // debug

?>
