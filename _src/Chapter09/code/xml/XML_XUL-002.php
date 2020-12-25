<?php
require_once 'XML/XUL.php';

// create a new document
$doc = XML_XUL::createDocument();

// link to the stylesheet selected by the user
$doc->addStylesheet('chrome://global/skin/');

// create a new window
$win = $doc->createElement('window',array(
                                      'title'=> 'Simple XUL'
                                     )
                           );
// add it to the document
$doc->addRoot($win);

// create another element
$desc = $doc->createElement('description', array(), 'This is XUL, believe it or not.');
$win->appendChild($desc);

header( 'Content-type: application/vnd.mozilla.xul+xml' );
$doc->send();
?>