<?php
$data = array(
          'artist' => 'Elvis Presley',
          'label'  => 'Sun Records',
          'record' => 'Viva Las Vegas'
        );
// include the class
require_once('XML/Serializer.php');

// create a new object
$serializer = new XML_Serializer();

// create the XML document
$serializer->serialize($data);

// fetch the document
echo $serializer->getSerializedData();
?>