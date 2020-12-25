<?php

require_once 'Date/TimeZone.php';

$london    = new Date_Timezone('Europe/London');    // UTC
$london2   = new Date_Timezone('Europe/London');    // UTC
$berlin    = new Date_Timezone('Europe/Berlin');    // UTC+1
$amsterdam = new Date_Timezone('Europe/Amsterdam'); // UTC+1

$london->isEqual($london2);
$london->isEqual($berlin);

$london->isEquivalent($berlin);
$berlin->isEquivalent($amsterdam);



// --- debug output ---
var_dump($london->isEqual($london2));
var_dump($london->isEqual($berlin));

var_dump($london->isEquivalent($berlin));
var_dump($berlin->isEquivalent($amsterdam));

?>
