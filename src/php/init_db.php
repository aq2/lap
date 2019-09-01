<?php  // initialise new database

require_once('functions.php');
require_once('table.php');

// destroy database if already exists, and start afresh
$db_file = '../data/aym.sqlite';
if (file_exists($db_file)) {
  unlink($db_file);
}

// create and populate new studios table
try {
  $db = getDB();

  $columns = ['studio_id', 'name', 'address'];
  $schema = ['INTEGER PRIMARY KEY', 'TEXT NOT NULL UNIQUE', 'TEXT NOT NULL'];
  $data = [
    "'Lotus Loft', 'Queen St'",
    "'derek', 'barking'",
    "'donkey', 'heeheaw'",
    "'Hunger', 'newton pop'",
    "'studio-line', 'haircut'"
  ];

  initTable('studios', $columns, $schema, $data);

  echo "<div id='adMessages'> database and studios successfully created.</div>";

} catch(PDOException $ex) {
  echo $ex->getMessage();
  die('database problemo');
}


function initTable($name, $columns, $schema, $data) {
  $table = new Table($name, $columns, $schema);
  // watch out if first column is INT PK - auto generated, so don't enter...
  if ($schema[0] == 'INTEGER PRIMARY KEY') {
    $columns = array_slice($columns, 1, count($columns)-1);
  }


  foreach($data as $datum) {
    $table->insert($columns, $datum);
  }


  echo "<div id='adMessages'>{$name} table successfully created.</div>";
}


?>
