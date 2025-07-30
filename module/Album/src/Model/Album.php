<?php

namespace Album\Model;

class Album
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray(array $array): void
    {
        $this->id = ! empty($array['id']) ? $array['id'] : null;
        $this->artist = ! empty($array['artist']) ? $array['artist'] : null;
        $this->title = ! empty($array['title']) ? $array['title'] : null;
    }
}
// Our Album entity object is a PHP class. In order to work with 
// laminas-db's TableGateway class, we need to implement the exchangeArray() 
// method; this method copies the data from the provided array to our 
// entity's properties. We will add an input filter later to ensure the 
// values injected are valid.