<?php

require_once 'Date/Span.php';

$span = new Date_Span('1,6:30:15');
print_r($span); // debug

$days    = $span->toDays();
$hours   = $span->toHours();
$minutes = $span->toMinutes();
$seconds = $span->toSeconds();


// --- debug output ---
echo 'Days: ' . $days . "\n";
echo 'Hours: ' . $hours . "\n";
echo 'Minutes: ' . $minutes . "\n";
echo 'Seconds: ' . $seconds . "\n";




?>
