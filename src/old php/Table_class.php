<?php

// require_once('functions.php'); # NOT needed, require it in code that uses class


// constructor 'gets' $columns, $rows
// this->createNew($data) to initiate and populate


class Table {
  public $name;
  public $rows;
  public $columns;
  public $num_rows;
  public $num_columns;
  public $keyed = false;

  public function __construct($name, $columns, $schema, $data) {

    $currentTables = getTableNames();
    while ($table = $currentTables->fetch()) {
        echo $table->name . '<br>';
    }

    // if $columns etc are set, make a new fucker
    $num_args = func_num_args();
    echo "<br> args: $num_args <br>";
    if (func_num_args() > 1) {
      $this->name = $name;
      $this->columns = $columns;
      $this->num_columns = count($columns);

      // if ($this->num_columns != count($schema)) {
      //   die("numbers of columns doesn't match number of schema!");
      // }
      // if ($schema[0] == 'INTEGER PRIMARY KEY') {
      //   $this->keyed = true;
      // }

      // now construct a table called $name using $schema data
      $sql = "CREATE TABLE {$name} (";

      for ($i=0; $i<$this->num_columns; $i++) {
        $sql .= "{$columns[$i]} {$schema[$i]}, ";
      }
      $sql = rtrim($sql, ', ');   # remove extraenous comma and space
      $sql .= ')';

      // now create table - try/catch perhaps?
      $db = getDB();
      $db->exec($sql);

      // now get the rows
      $sql = "PRAGMA table_info(studios);";
      $results = $db->query($sql);
      while ($row = $results->fetch()) {
        echo "{$row->name}";
        array_push($this->columns, $row->name);
      }
      print_r($this->columns);

      $db = null;   # close connection
    } else {
      // return $rows and $columns
      // $db = getDB();
        // $this->columns_push($row->name);
    }
}


  public function insert($columns, $values) {
    // check that column names given match $this→columns, which is an array
    // → need to convert it into string of same format as $columns
    $thc = "'" . implode("', '", $columns) . "'";  # must be a better way

    // TODO - spose we should check values too...
    // just need to check count...

    // if table is keyed (ie 1st col is INT PK), then don't insert into 1st col
    $columns_noPK = array_slice($this->columns, 1, $this->num_columns - 1);  # removes col[0]

    // really not sure about this line below!
    // TODO improve crazy logic!
    if (!(
        (($this->keyed) && ($columns != $columns_noPK))
        || ($columns != $this->columns)
      )) {
      echo "<br>";
      echo '$columns:           ';
      print_r($columns);
      echo '<br>$this->columns: ';
      print_r($this->columns);
      echo '<br>$columns_noPK: ';
      print_r($columns_noPK);

      die("<br>haven't passed the right columns for the $this->name table! <br>");
    } else {
      // prepare our sql and do db stuff
      $sql = "INSERT INTO '{$this->name}' ({$thc}) VALUES ({$values})";
      $db = getDB();   # already try/catched
      $statement = $db->prepare($sql);
      $statement->execute();  # should this be tried?
      $db = null;
    }
  }

  public function getNumColumns() {
    return $this->num_columns;
  }

 /* public function getById($id) {} */
  /* public function updateById($id) {} */
  /* public function getAllRows() {} */
  /* public function getColumns() {} */

}



?>
