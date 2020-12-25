<?php

require_once 'Date.php';

$d1 = new Date('2005-12-24');
$d2 = new Date('2005-12-30');

$equal        = $d1->equals($d2);
$d1_Before_d2 = $d1->before($d2);
$d1_After_d2  = $d1->after($d2);


// ---- debug output ----

echo $equal ? 'yes' : 'no'; echo "\n";
echo $d1_Before_d2 ? 'yes' : 'no'; echo "\n";
echo $d1_After_d2 ? 'yes' : 'no'; echo "\n";

?>
