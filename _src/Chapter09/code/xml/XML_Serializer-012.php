<?php
header('Content-Type: text/xml');

require_once 'example-create-objects.php';

// include the class
require_once('XML/Serializer.php');

// create a new object
$serializer = new XML_Serializer();

// set options
$serializer->setOption(XML_SERIALIZER_OPTION_XML_DECL_ENABLED, true);
$serializer->setOption(XML_SERIALIZER_OPTION_XML_ENCODING, 'ISO-8859-1');
$serializer->setOption(XML_SERIALIZER_OPTION_INDENT, '    ');

// create the XML document
$serializer->serialize($labels);

// fetch the document
echo $serializer->getSerializedData();
?>