<?php

require_once 'Date.php';

$dateObj = new Date('2005-12-24 09:30:00');
echo 'Default: ' . $dateObj->getDate() . "\n";
echo 'DATE_FORMAT_ISO: ' . $dateObj->getDate(DATE_FORMAT_ISO) . "\n";
echo 'DATE_FORMAT_ISO_BASIC: ' . $dateObj->getDate(DATE_FORMAT_ISO_BASIC) . "\n";
echo 'DATE_FORMAT_ISO_EXTENDED: ' . $dateObj->getDate(DATE_FORMAT_ISO_EXTENDED) . "\n";
echo 'DATE_FORMAT_ISO_EXTENDED_MICROTIME: ' . $dateObj->getDate(DATE_FORMAT_ISO_EXTENDED_MICROTIME) . "\n";
echo 'DATE_FORMAT_TIMESTAMP: ' . $dateObj->getDate(DATE_FORMAT_TIMESTAMP) . "\n";
echo 'DATE_FORMAT_UNIXTIME: ' . $dateObj->getDate(DATE_FORMAT_UNIXTIME) . "\n";

?>
