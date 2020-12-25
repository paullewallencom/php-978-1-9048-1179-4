<?php
error_reporting(E_ALL);
setlocale(LC_ALL, 'en_US');

require_once 'Calendar/Month/Weekdays.php';
require_once 'Calendar/Util/Uri.php';

// get date information from request or use current date 
$y = isset($_GET['year']) ? $_GET['year'] : date('Y');
$m = isset($_GET['month']) ? $_GET['month'] : date('m');

$month = &new Calendar_Month_Weekdays($y, $m, $firstDay = 1);
$month->build();

// Localized text for the calendar headline
$header = strftime('%B %Y', $month->thisMonth('timestamp'));

// URI Util for generation of navigation links
$uriUtil = &new Calendar_Util_Uri('year', 'month');
$nextM = $uriUtil->next($month, 'month');
$prevM = $uriUtil->prev($month, 'month');

echo <<<EOQ
<table width="250">
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
        echo '<td><div>&nbsp;</div></td>';
    } else {
        echo '<td align="center"><div>'.$day->thisDay().'</div></td>';
    }

    if ($day->isLast()) {
        echo "</tr>\n";
    }
}
echo '</table>';

?>
