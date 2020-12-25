<?php

require_once 'Date/Span.php';

$span1 = new Date_Span('1 hour');
$span2 = new Date_Span('2 hours');

$span1->add($span2);

print_r($span1); // debug
?>
