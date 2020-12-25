<?php
require_once 'example-create-objects.php';
require_once 'XML/FastCreate.php';

header('Content-Type: text/xml');
$options = array(
                 'encoding'   => 'ISO-8859-1',
                 'standalone' => 'yes'
               );
$xml = XML_FastCreate::factory('Text', $options);
// This variable will store all labels as XML
$labelsXML = '';

// Traverse the record labels in the array
foreach ($labels as $label) {
    
    // This variable will store all artists of the label as XML
    $artistsXML = '';
    
    // traverse all artists
	foreach ($label->artists as $artist) {
	    
	    // This variable will store all records of the artist as XML
	    $records = '';
	    
	    // traverse all records
    	foreach ($artist->records as $record) {
    	    $recordAtts = array(
    	                        'id'       => $record->id,
    	                        'released' => $record->released
    	                      );
            // Create and append one <record/>
    	    $records .= $xml->record($recordAtts, $xml->name($record->name));
    	}
    	$artistAtts = array('id' => $artist->id);
    	
    	// Create and append one <artist/>
        $artistsXML .= $xml->artist($artistAtts, $xml->records($records));
	}
	$labelAtts = array('name' => $label->name);
	
	// Create and append one <label/>
	$labelsXML .= $xml->label($labelAtts, $xml->artists($artistsXML));
}
$xml->labels($labelsXML);
$xml->toXML();
?>