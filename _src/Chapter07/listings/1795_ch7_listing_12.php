<?php

require_once 'Date/Span.php';

$span  = new Date_Span('');
$empty = $span->isEmpty();


var_dump($empty); // debug

?>
