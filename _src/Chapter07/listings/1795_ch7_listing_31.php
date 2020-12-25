<?php

require_once 'Date/Holidays.php';

// driver uses Italian translations by default
$driver  = Date_Holidays::factory('Christian', 2005, 'it_IT');

$driver->addCompiledTranslationFile(
    '/var/lib/pear/data/Date_Holidays/lang/Christian/it_IT.ser', 'it_IT');
$driver->addCompiledTranslationFile(
    '/var/lib/pear/data/Date_Holidays/lang/Christian/fr_FR.ser', 'fr_FR');

// uses default translations
echo $driver->getHolidayTitle('easter') . "\n";

// per-method French translation
echo $driver->getHolidayTitle('easter', 'fr_FR') . "\n";

// set fr_FR as default locale
$driver->setLocale('fr_FR');

// uses default translations. now French
echo $driver->getHolidayTitle('easter') . "\n";

?>
