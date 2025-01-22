<?php 
require_once('class_recipe.php');

class Image extends Recipe {
  private $imageFull;
  
  public function __construct($id, $name, $image, $main, $imageFull) {
    parent::__construct($id, $name, $image, $main);
    $this->imageFull = $imageFull;
  }
  
  public function getImageFull() {
    return $this->imageFull;
  }  
}

?>