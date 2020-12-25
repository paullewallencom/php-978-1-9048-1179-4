<?php

require_once 'Date/Holidays.php';

$driver = Date_Holidays::factory('Christian', 2005, 'fr_FR');
$driver->addCompiledTranslationFile(
    '/var/lib/pear5/data/Date_Holidays/lang/Christian/fr_FR.ser', 'fr_FR');

// default setting, no need to explicitly set this
Date_Holidays::staticSetProperty('DIE_ON_MISSING_LOCALE', true);

$title = $driver->getHolidayTitle('whitMonday');
if (Date_Holidays::isError($title)) {
  echo $title->getMessage();
} else {
  echo $title;
}

echo "\n---\n";

// default setting, no need to explicitly set this
Date_Holidays::staticSetProperty('DIE_ON_MISSING_LOCALE', false);

// no need to check for an error but title may not be correctly localized
echo $driver->getHolidayTitle('whitMonday') . "\n";

?>
