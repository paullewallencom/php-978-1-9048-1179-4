<?php
require_once 'example-classes.php';
// create the new label
$sun    = new Label('Sun Records');
// create a new artist
$elvis  = new Artist('Elvis Presley');

// add the artist to the list of signed artists
$sun->signArtist($elvis);

// record two albums
$elvis->recordAlbum(
                new Record('SUN 209',
                           'That\'s All Right (Mama) & Blue Moon Of Kentucky',
                           'July 19, 1954'
                          )
                );
$elvis->recordAlbum(
                new Record('SUN 210',
                           'Good Rockin\' Tonight',
                           'September, 1954'
                          )
                );

// Create a second artist and record an album
$carl = new Artist('Carl Perkins');
$carl->recordAlbum(
                new Record('SUN 224',
                           'Gone, Gone, Gone',
                           'October 22, 1955'
                          )
                );
// Add the artist to the label
$sun->signArtist($carl);
                
// create a list of labels (if we have more
// than one label at a later point)
$labels = array($sun);
?>