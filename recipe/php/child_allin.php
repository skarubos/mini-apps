<?php 
require_once('class_recipe.php');

class Allin extends Recipe {
  private $materials;
  private $steps;
  private $url;
  
  public function __construct($id, $name, $image, $main, $table) {
    parent::__construct($id, $name, $image, $main);
    $this->table = $table;
  }

  public function getTable() {
    return $this->table;
  }
  
}

?>