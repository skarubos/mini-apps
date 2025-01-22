<?php

class Bookmark {
    public static $count = 0;
    private $id;
    private $name;
    private $url;
    private $image;
    public function __construct($id, $name, $url, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
        $this->image = $image;
        self::$count++;
    }
    public function getID(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getURL(){
        return $this->url;
    }
    public function getImage(){
        return $this->image;
    }

}
