<?php
require_once 'example-classes2.php';
// include the class
require_once 'XML/Unserializer.php';

// create a new object
$unserializer = new XML_Unserializer();

$unserializer->setOption(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE, true);
$types = array(
            '#default' => 'object',
            'artists'  => 'array',
            'labels'   => 'array',
            'records'  => 'array'
         );
$unserializer->setOption(XML_UNSERIALIZER_OPTION_COMPLEXTYPE, $types);
$unserializer->setOption(XML_UNSERIALIZER_OPTION_FORCE_ENUM, array('label'));
$unserializer->setOption(XML_UNSERIALIZER_OPTION_IGNORE_KEYS, array('label', 'artist', 'record'));

$unserializer->unserialize('first-xml-document.xml', true);

echo '<pre>';
print_r($unserializer->getUnserializedData());
echo '</pre>';
?>