<?php
require_once 'MDB2/Schema.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$dsn = 'mysql://pear:pear@localhost/pearserver';
$sch = &MDB2_Schema::factory($dsn);
