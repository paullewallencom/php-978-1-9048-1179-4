<?php

require_once 'Date/Span.php';

$span1 = new Date_Span('1,6:30:15');
$span2 = new Date_Span('2,12:30:15');
print_r($span1); // debug
print_r($span2); // debug

$span1->lower($span2);
$span1->lowerEqual($span2);
$span1->equal($span2);
$span1->greater($span2);
$span1->greaterEqual($span2);


// --- debug output ---
echo 'lt: '; echo ($span1->lower($span2)) ? 'yes' : 'no'; echo "\n";
echo 'le: '; echo ($span1->lowerEqual($span2)) ? 'yes' : 'no'; echo "\n";
echo 'eq: '; echo ($span1->equal($span2)) ? 'yes' : 'no'; echo "\n";
echo 'ge: '; echo ($span1->greaterEqual($span2)) ? 'yes' : 'no'; echo "\n";
echo 'gt: '; echo ($span1->greater($span2)) ? 'yes' : 'no'; echo "\n";


?>
