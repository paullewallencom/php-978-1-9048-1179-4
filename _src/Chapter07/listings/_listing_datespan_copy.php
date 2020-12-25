<?php

// OBSOLETE!
// not used in the text any longer
//

require_once 'Date/Span.php';

$span1 = new Date_Span('1 hour');
$span2 = new Date_Span('2 hours');

$span1->copy($span2);
print_r($span1);
?>
