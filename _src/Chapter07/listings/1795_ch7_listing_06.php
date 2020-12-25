<?php

require_once 'Date.php';

$date = new Date('2005-12-24 09:30:00');
echo $date->format('%A, %D %T');

?>
