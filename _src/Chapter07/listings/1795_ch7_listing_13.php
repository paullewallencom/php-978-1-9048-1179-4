<?php

require_once 'Date.php';
require_once 'Date/Span.php';

$date = new Date('2005-12-24 12:00:00');
$span = new Date_Span('2, 00:00:00');

$date->subtractSpan($span);
echo $date->getDate();

?>
