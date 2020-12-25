<?php
error_reporting(E_ALL);

require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Util/Uri.php';
require_once 'Calendar/Day.php';
require_once 'Date.php';
require_once 'Date/Holidays.php';
require_once 'Calendar_Decorator_Holiday.php';

setlocale(LC_ALL, $locale= 'en_US');

// get date information from request or use current date 
$y = sprintf('%04d', isset($_GET['year']) ? $_GET['year'] : date('Y'));
$m = sprintf('%02d', isset($_GET['month']) ? $_GET['month'] : date('m'));

// get holidays for the displayed month
$startDate = new Date($y .'-'. $m . '-01 00:00:00');
$endDate   = new Date($y .'-'. $m . '-01 00:00:00');
$endDate->setDay($endDate->getDaysInMonth());
$driver = Date_Holidays::factory('Christian', $y, $locale);
if (Date_Holidays::isError($driver)) {
  die('Creation of driver failed: ' . $driver->getMessage());
} 
$holidays = $driver->getHolidaysForDatespan($startDate, $endDate);
if (Date_Holidays::isError($holidays)) {
  die('Error while retrieving holidays: ' . $holidays->getMessage());
} 

// create selection-array with decorated objects for the Calendar::build() method
$selection = array();
foreach ($holidays as $holiday) {
  $date = $holiday->getDate();
  $day  = new Calendar_Day($date->getYear(), $date->getMonth(), $date->getDay());
  $selection[] = new Calendar_Decorator_Holiday($day, $holiday);
}

$month = &new Calendar_Month_Weekdays($y, $m, $firstDay = 1);
$month->build($selection);

// Localized text for the calendar headline
$header = strftime('%B %Y', $month->thisMonth('timestamp'));

// URI Util for generation of navigation links
$uriUtil = &new Calendar_Util_Uri('year', 'month');
$nextM = $uriUtil->next($month, 'month');
$prevM = $uriUtil->prev($month, 'month');

echo <<<EOQ
<style type="text/css">
  div.empty {background-color: #bfbfbf;}
  div.holiday {background-color: #b8ffa4;}
</style>

<table width="250" cellpadding="0" cellspacing="0">
  <!-- calendar headline -->
  <tr>
    <td align="left"><a href="{$_SERVER['PHP_SELF']}?$prevM">&lt;</a></td>
    <td colspan="5" align="center">$header</td>
    <td align="right"><a href="{$_SERVER['PHP_SELF']}?$nextM">&gt;</td>
  </tr>
  <tr>
    <td align="center">Mon</td>
    <td align="center">Tue</td>
    <td align="center">Wed</td>
    <td align="center">Thu</td>
    <td align="center">Fri</td>
    <td align="center">Sat</td>
    <td align="center">Sun</td>
   </tr>
  
  <!-- calendar data -->
  <tr>
EOQ;

// iterate over the built weekdays and display them
while ($day = & $month->fetch()) {
  if ($day->isFirst()) {
      echo '<tr>';
  }

  if ($day->isEmpty()) {
    echo '<td><div class="empty">&nbsp;</div></td>';
  } else {
    if ($day->isSelected()) {
      echo '<td align="center"><div class="holiday" '
          . 'title="' . $day->getHoliday()->getTitle() . '">'.$day->thisDay()
          . '</div></td>';
    } else {
      echo '<td align="center"><div>'.$day->thisDay().'</div></td>';
    }
  }

  if ($day->isLast()) {
    echo "</tr>\n";
  }
}
echo '</table>';

?>