<?php

require_once 'Date/Holidays.php';

$driver = Date_Holidays::factory('Christian', 2005);
$file   = '/var/lib/pear/data/Date_Holidays/lang/Christian/fr_FR.xml';
$driver->addTranslationFile($file, 'fr_FR');


// --- debug output ---
var_dump($driver->addTranslationFile($file, 'fr_FR'));

?>
