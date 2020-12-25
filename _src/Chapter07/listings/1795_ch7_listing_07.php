<?php

require_once 'Date/Span.php';

$span = new Date_Span(array(1, 6, 30, 15));
print_r($span); // debug

$span = new Date_Span(
  new Date('2005-01-01 00:00:00'),
  new Date('2005-01-02 06:30:15'));
print_r($span); // debug

$span = new Date_Span(109815);
print_r($span); // debug

$span = new Date_Span('1,6,30,15');
print_r($span); // debug
?>
