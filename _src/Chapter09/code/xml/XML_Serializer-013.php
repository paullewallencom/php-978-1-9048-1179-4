<?php
require_once 'example-create-objects.php';
require_once 'XML/Serializer.php';

header('Content-Type: text/xml');

$serializer = new XML_Serializer();

// configure the XML declaration
$serializer->setOption(XML_SERIALIZER_OPTION_XML_DECL_ENABLED, true);
$serializer->setOption(XML_SERIALIZER_OPTION_XML_ENCODING, 'ISO-8859-1');

// configure the layout
$serializer->setOption(XML_SERIALIZER_OPTION_INDENT, '    ');
$serializer->setOption(XML_SERIALIZER_OPTION_LINEBREAKS, "\n");

// configure tag names
$serializer->setOption(XML_SERIALIZER_OPTION_ROOT_NAME, 'labels');
$tagNames = array(
                  'labels'  => 'label',
                  'artists' => 'artist',
                  'records' => 'record'
                );
$serializer->setOption(XML_SERIALIZER_OPTION_DEFAULT_TAG, $tagNames);

$attributes = array(
                  'label'  => array('name'),
                  'artist' => array('id'),
                  'record' => array('id', 'released')
                );
$serializer->setOption(XML_SERIALIZER_OPTION_SCALAR_AS_ATTRIBUTES, $attributes);
                
$result = $serializer->serialize($labels);

echo $serializer->getSerializedData();
?>