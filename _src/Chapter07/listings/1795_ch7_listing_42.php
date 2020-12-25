<?php
error_reporting(E_ALL);
setlocale(LC_ALL, 'en_US');

require_once 'Calendar/Month/Weekdays.php';

// September 2005, first day is Monday
$month = &new Calendar_Month_Weekdays(2005, 9, $firstDay = 1);
$month->build();

// localized text for the calendar headline
$header = strftime('%B %Y', $month->thisMonth('timestamp'));

echo <<<EOQ
<table width="250">
    <!-- calendar headline -->
    <tr><td colspan="7" align="center">$header</td></tr>
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
while ($Day = & $month->fetch()) {
    if ($Day->isFirst()) {
        echo '<tr>';
    }
    
    if ($Day->isEmpty()) {
        echo '<td><div>&nbsp;</div></td>';
    } else {
        echo '<td align="center"><div>'.$Day->thisDay().'</div></td>';
    }
    
    if ($Day->isLast()) {
        echo "</tr>\n";
    }
}
echo '</table>';

?>