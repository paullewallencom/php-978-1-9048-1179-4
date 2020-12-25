<?php
require_once 'XML/Unserializer.php';

$unserializer = new XML_Unserializer();

// parse attributes as well
$unserializer->setOption(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE, true);

$unserializer->unserialize('XML_Parser-001.xml', true);
$config = $unserializer->getUnserializedData();
print_r($config);
?>