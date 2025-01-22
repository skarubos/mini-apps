<?php
class Recipe {
  protected $id;
  protected $name;
  protected $image;
  protected $main;
  
  public function __construct($id, $name, $image, $main) {
    $this->id = $id;
    $this->name = $name;
    $this->image = $image;
    $this->main = $main;
  }

  public function getID() {
    return $this->id;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function getImage() {
    return $this->image;
  }
  
  public function getMain() {
    return $this->main;
  }
}
?>