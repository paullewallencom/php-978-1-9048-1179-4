<?php
require_once 'example-create-objects.php';
require_once 'XML/Serializer.php';

header('Content-Type: text/xml');

$serializer = new XML_Serializer();

// configure the XML declaration
$serializer->setOption(XML_SERIALIZER_OPTION_XML_DECL_ENABLED, true);
$serializer->setOption(XML_SERIALIZER_OPTION_XML_ENCODING, 'ISO-8859-1');

$serializer->setOption(XML_SERIALIZER_OPTION_TYPEHINTS, true);

// configure the layout
$serializer->setOption(XML_SERIALIZER_OPTION_INDENT, '    ');
$serializer->setOption(XML_SERIALIZER_OPTION_LINEBREAKS, "\n");

$serializer->setOption(XML_SERIALIZER_OPTION_DEFAULT_TAG, $tagNames);

$result = $serializer->serialize($labels);

echo $serializer->getSerializedData();
?>