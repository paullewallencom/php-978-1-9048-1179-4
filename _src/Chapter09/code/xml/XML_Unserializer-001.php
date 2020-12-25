<?php
// include the class
require_once 'XML/Unserializer.php';

// create a new object
$unserializer = new XML_Unserializer();

// construct some XML
$xml = <<<XML
<artists>
    <artist>Elvis Presley</artist>
    <artist>Carl Perkins</artist>
</artists>
XML;

$unserializer->unserialize($xml);
$artists = $unserializer->getUnserializedData();
print_r($artists);

echo $unserializer->getRootName();
?>