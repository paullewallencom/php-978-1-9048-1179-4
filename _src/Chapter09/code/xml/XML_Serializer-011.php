<?php
header('Content-Type: text/xml');
$data = array(
          'artist'  => array(
                        'name'  => 'Elvis Presley',
                        'email' => 'elvis@graceland.com'
                       ),
          'labels'  => array(
                        'Sun Records',
                        'Sony Music'
                       ),
          'records' => array(
                        'Viva Las Vegas',
                        'Hound Dog',
                        'In the Ghetto'
                       )
        );
// include the class
require_once('XML/Serializer.php');

// create a new object
$serializer = new XML_Serializer();

// set options
$serializer->setOption(XML_SERIALIZER_OPTION_XML_DECL_ENABLED, true);
$serializer->setOption(XML_SERIALIZER_OPTION_XML_ENCODING, 'ISO-8859-1');
$serializer->setOption(XML_SERIALIZER_OPTION_INDENT, '    ');
$serializer->setOption(XML_SERIALIZER_OPTION_ROOT_NAME, 'artist-info');
$serializer->setOption(XML_SERIALIZER_OPTION_SCALAR_AS_ATTRIBUTES,
                       array(
                         'artist' => array('email')
                           )
                       );
$serializer->setOption(XML_SERIALIZER_OPTION_DEFAULT_TAG,
                       array(
                         'labels'  => 'label',
                         'records' => 'record'
                            )
                      );

// create the XML document
$serializer->serialize($data);

// fetch the document
echo $serializer->getSerializedData();
?>