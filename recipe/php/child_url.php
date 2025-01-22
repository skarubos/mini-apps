<?php 
require_once('class_recipe.php');

class URL extends Recipe {
  private $url;
  
  public function __construct($id, $name, $image, $main, $url) {
    parent::__construct($id, $name, $image, $main);
    $this->url = $url;
  }
  
  public function getURL() {
    return $this->url;
  }  
}

?>