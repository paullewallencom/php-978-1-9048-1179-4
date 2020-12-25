<?php
// include the base class
require_once 'XML/Parser.php';

// create a class that extends XML_Parser
class ConfigReader extends XML_Parser
{
   /**
    * handle opening tags
    *
    * @param    resource    parser resource
    * @param    string      tag name
    * @param    array       attributes
    */
    public function startHandler($parser, $name, $attribs)
    {
        echo "Start element $name found\n";
    }

   /**
    * handle character data
    *
    * @param    resource    parser resource
    * @param    string      character data
    */
    public function cdataHandler($parser, $cData)
    {
        $cData = trim($cData);
        if ($cData === '') {
            return;
        }
        echo "...data '$cData' found\n";
    }
    
   /**
    * handle closing tags
    *
    * @param    resource    parser resource
    * @param    string      tag name
    */
    public function endHandler($parser, $name)
    {
        echo "End element $name found\n";
    }
}

// Create a new instance of the class
$config = new ConfigReader();

// set the name of the file to parse
$config->setInputFile('XML_Parser-001.xml');

// parse the file and catch errors
$result = $config->parse();
if (PEAR::isError($result)) {
    echo 'Parsing failed: ' . $result->getMessage();
}
$config->free();
?>