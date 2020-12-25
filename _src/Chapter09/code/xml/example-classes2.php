<?php
/**
 * Store information about a record label
 * and the signed artists
 */
class Label {
    public $name    = null;
    public $artists = array();
    
    public function __construct($name = null) {
        $this->name = $name;
    }
    public function signArtist(Artist $artist) {
        // get the next higher id
        $artist->setId(count($this->artists)+1);
        $this->artists[] = $artist;
    }
}

/**
 * Store information about an artist
 * and the records he released
 */
class Artist {
    public $id      = null;
    public $name    = null;
    public $records = array();
    
    public function __construct($name = null) {
        $this->name = $name;
    }
    public function setId($id) {
        $this->id = $id;
    }    
    public function recordAlbum(Record $album) {
        $this->records[] = $album;
    }
}

/**
 * Store information about a record.
 */
class Record {
    public $id       = null;
    public $name     = null;
    public $released = null;
    
    public function __construct($id = null, $name = null, $released = null) {
        $this->id       = $id;
        $this->name     = $name;
        $this->released = $released;
    }
}
?>