<?php
header('Content-Type: text/xml');

require_once 'example-create-objects.php';

// include the class
require_once('XML/Serializer.php');

class UrlFetcher {
    public $url  = null;
    public $html = null;
    
    public function __construct($url) {
        $this->url  = $url;
        $this->html = file_get_contents($this->url);
    }
}

// create a new object
$serializer = new XML_Serializer();

// set options
$serializer->setOption(XML_SERIALIZER_OPTION_XML_DECL_ENABLED, true);
$serializer->setOption(XML_SERIALIZER_OPTION_XML_ENCODING, 'ISO-8859-1');
$serializer->setOption(XML_SERIALIZER_OPTION_INDENT, '    ');

$pear = new UrlFetcher('http://pear.php.net');

// create the XML document
$serializer->serialize($pear);

// fetch the document
echo $serializer->getSerializedData();
?>