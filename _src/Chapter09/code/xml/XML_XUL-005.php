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

// Create a tabbox and add it to the window
$tabbox = &$doc->createElement('Tabbox', array('height' => 500));
$win->appendChild($tabbox);

// Create a new tree
$tree = &$doc->createElement('Tree',
                                array(
                                  'flex' => 1,
                                  'height' => 200
                                )
                            );

// Set the column labels
$tree->setColumns(3,
                     array(
                       'id'      => 'id',
                       'label'   => 'Id',
                       'flex'    => 1,
                       'primary' => 'true'
                     ),
                     array(
                       'id'      => 'name',
                       'label'   => 'Name',
                       'flex'    => 1
                     ),
                     array(
                       'id'      => 'email',
                       'label'   => 'E-Mail',
                       'flex'    => 1
                     )
                 );

// add a new entry to the tree
$sun = $tree->addItem(array('SUN', 'Sun Records', 'info@sun-records.com'));

// Add two new subentries to the created entry
$sun->addItem(array('elvis', 'Elvis Presley', 'elvis@graceland.com'));
$sun->addItem(array('carl', 'Carl Perkins', 'carl@sun-records.com'));

// add another entry to the tree
$tree->addItem(array('SONY', 'Sony Records', 'info@sony.com'));

// Add a new tab to the label and use the tree as content
$tabbox->addTab('Labels', $tree, array(), array('height' => 200));

// Add another tab without content
$tab2 = $tabbox->addTab('Misc');

// Add simple text content to the second tab
$tab2->addDescription('Place any content here.');

header( 'Content-type: application/vnd.mozilla.xul+xml' );
$doc->send();
?>