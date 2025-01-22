<?php

class Shopping {
    public static $count = 0;
    private $id;
    private $name;
    public function __construct($id, $name, $date) {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        self::$count++;
    }
    public function getID(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDate(){
        return $this->date;
    }
}
