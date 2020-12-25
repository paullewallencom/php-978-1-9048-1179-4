<?php
require_once 'example-create-objects.php';
require_once 'XML/Util.php';

header('Content-Type: text/xml');

echo XML_Util::getXMLDeclaration('1.0', 'ISO-8859-1');
echo XML_Util::createStartElement('labels') . "\n";

foreach ($labels as $label) {
	echo XML_Util::createStartElement('label', array('name' => $label->name)) . "\n";
	echo XML_Util::createStartElement('artists') . "\n";
	foreach ($label->artists as $artist) {
    	echo XML_Util::createStartElement('artist', array('id' => $artist->id)) . "\n";
    	echo XML_Util::createTag('name', array(), $artist->name) . "\n";
    	
    	echo XML_Util::createStartElement('records') . "\n";
    	foreach ($artist->records as $record) {
            echo XML_Util::createStartElement('record', array(
                                                        'id'       => $record->id,
                                                        'released' => $record->released)
                                             ) . "\n";
        	echo XML_Util::createTag('name', array(), $record->name) . "\n";
        	echo XML_Util::createEndElement('record') . "\n";
    	}
    	echo XML_Util::createEndElement('records') . "\n";

    	echo XML_Util::createEndElement('artist') . "\n";
	}
	echo XML_Util::createEndElement('artists') . "\n";
	echo XML_Util::createEndElement('label') . "\n";
}

echo XML_Util::createEndElement('labels') . "\n";
?>