<?php
// include the class
require_once('XML/Serializer.php');

// create a new object
$serializer = new XML_Serializer();

// create the XML document
$serializer->serialize('This is a string');

// fetch the document
echo $serializer->getSerializedData();
?>