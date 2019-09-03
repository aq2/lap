<?php
  require_once('functions.php');
  require_once('Table_class.php');

if (isset($_GET['initdb'])) {

  // destroy database if already exists, and start afresh
  $db_file = '../../data/aym.sqlite';
  if (file_exists($db_file)) {
    unlink($db_file);
  }

  // create and populate new studios table
  try {
    $db = getDB();

    $columns = ['studio_id', 'name', 'address', 'mapRef'];
    $schema = ['INTEGER PRIMARY KEY', 'TEXT NOT NULL UNIQUE', 'TEXT NOT NULL', 'TEXT'];
    $data = [
      "'Lotus Loft Yoga Centre', '25 Southernhay East, Exeter', '!1m18!1m12!1m3!1d2525.8342564783893!2d-3.5261599999999653!3d50.723014000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43db07c12b7%3A0x7cc3e5bad826796d!2sLotus+Loft!5e0!3m2!1sen!2suk!4v1422712288800'",
      "'derekthedog Yoga Centre', '83/84 Queen St, Exeter', '!1m14!1m8!1m3!1d5051.451978693518!2d-3.5314212749199507!3d50.72502247256642!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43be056ab0b%3A0x9431c90b86e7d057!2sDerekthedog+Yoga+Centre!5e0!3m2!1sen!2suk!4v1422711334901'",
      "'Hunger Hill Yurts', 'Newton Poppleford, Sidmouth', '!1m18!1m12!1m3!1d96285.95364073697!2d-3.3628547408609584!3d50.64191093906292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486d9ea450520d97%3A0xe9396096ca54de57!2sHunger+Hill+Yurts!5e0!3m2!1sen!2suk!4v1563455133627!5m2!1sen!2suk'",
    ];

    initTable('studios', $columns, $schema, $data);

    echo "<div id='adMessages'> database and studios successfully created.</div>";
    @$yep = new Table($name = 'bob');

  } catch(PDOException $ex) {
    echo $ex->getMessage();
    die('database problemo');
  }



}  # endif intidb

function initTable($name, $columns, $schema, $data) {
  $table = new Table($name, $columns, $schema, $data);
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
