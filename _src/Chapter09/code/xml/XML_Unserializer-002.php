<?php
// include the class
require_once 'XML/Unserializer.php';

// create a new object
$unserializer = new XML_Unserializer();

$unserializer->unserialize('XML_Parser-001.xml', true);
$config = $unserializer->getUnserializedData();
print_r($config);
?>