<?php

class Table {
  public $name;
  public $rows;
  public $columns;
  public $num_rows;
  public $num_columns;


  /* public function insertInto($data) {} */
  /* public function getById($id) {} */
  /* public function updateById($id) {} */
  /* public function getAllRows() {} */
  /* public function getColumns() {} */

  public function __construct($name, $columns) {
    $this->name = $name;
    $this->columns = $columns;
    // now construct a table with $name and $columns array
    echo "...constructed...";
  }


  public function getNumRows() {
    return;
  }
}

// test it!

$studios = new Table('studios', -);
var_dump($studios);
echo '<br>';
print_r($studios);




?>
