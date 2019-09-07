<?php

require_once('db_functions.php');
require_once('admin_buttons.php');
initdb();


function initdb() {
  $db_file = '../../data/aym.sqlite';
  if (file_exists($db_file)) {    # delete it
    unlink($db_file);
  }

  // create and populate new studios table
  try {
    $db = getDB();
    $columns = ['studio_id', 'name', 'address', 'mapRef'];
    $schema = ['INTEGER PRIMARY KEY', 'TEXT NOT NULL UNIQUE', 'TEXT NOT NULL', 'TEXT'];
    $records = [
      ['Lotus Loft Yoga Centre', '25 Southernhay East, Exeter', '!1m18!1m12!1m3!1d2525.8342564783893!2d-3.5261599999999653!3d50.723014000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43db07c12b7%3A0x7cc3e5bad826796d!2sLotus+Loft!5e0!3m2!1sen!2suk!4v1422712288800'],
      ['derekthedog Yoga Centre', '83/84 Queen St, Exeter', '!1m14!1m8!1m3!1d5051.451978693518!2d-3.5314212749199507!3d50.72502247256642!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43be056ab0b%3A0x9431c90b86e7d057!2sDerekthedog+Yoga+Centre!5e0!3m2!1sen!2suk!4v1422711334901'],
      ['Hunger Hill Yurts', 'Newton Poppleford, Sidmouth', '!1m18!1m12!1m3!1d96285.95364073697!2d-3.3628547408609584!3d50.64191093906292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486d9ea450520d97%3A0xe9396096ca54de57!2sHunger+Hill+Yurts!5e0!3m2!1sen!2suk!4v1563455133627!5m2!1sen!2suk'],
    ];
    initTable('studios', $columns, $schema, $records);

    $columns = ['workshop_id', 'date', 'time', 'studio_id', 'type'];
    $schema = ['INTEGER PRIMARY KEY', 'TEXT NOT NULL', 'TEXT NOT NULL', 'INTEGER NOT NULL', 'TEXT NOT NULL'];
    $records = [
      ['Sat 28th September 2019', '1-4pm', 4, 'aym'],
      ['Sat 26th October 2019', '2-5pm', 1, 'aym'],
      ['Sat 23rd November 2019', '2-5pm', 1, 'aym'],
      ['Sat 15th February 2020', '2-5pm', 1, 'aym'],
      ['Sat 6th June 2020', '10am-1pm', 1, 'aym'],
      ['Sat 30th October 2019', '10am-1pm', 1, 'aym'],
      ['Thu 14 - Sun 17 November 2019', '9am-4pm', 3, 'intensive'],
      ['Thu 12 - Sun 15 March 2020', '9am-4pm', 3, 'intensive'],
      ['Thu 15 - Sun 18 October 2020', '9am-4pm', 3, 'intensive'],
      ['Sat 21st September 2019', '1-4pm', 2, 'yoga'],
      ['Sat 15th December 2020', '1-4pm', 2, 'yoga']
    ];
    initTable('workshops', $columns, $schema, $records);

    // clients
    // contacts/messages


    echo "<div id='adMessages'> database and studios successfully created.</div>";
  } catch(PDOException $ex) {
    echo $ex->getMessage();
    die('database problemo');
  }
}


// construct a table called $name using da data
function initTable($name, $columns, $schema, $records) {
  $num_cols = count($columns);

  $sql = "CREATE TABLE {$name} (";
  for ($i=0; $i<$num_cols; $i++) {
    $sql .= "{$columns[$i]} {$schema[$i]}, ";
  }
  $sql = rtrim($sql, ', ');   # remove extraenous comma and space
  $sql .= ')';                # maybe better done with a while or foreach?

  // now create table - try/catch perhaps?
  $db = getDB();
  $db->exec($sql);

  // watch out if first column is INT PK - auto generated, so don't enter...
  if ($schema[0] == 'INTEGER PRIMARY KEY') {
    $columns = array_slice($columns, 1, count($columns)-1);
  }

  $column_str = "'" . join("', '", $columns) . "'";   # oh, really??

  // TODO replace ? with column name?
  $sql = "INSERT INTO $name ({$column_str}) VALUES (?";
  for ($i=0; $i<$num_cols-2; $i++) {
    $sql .= ",?";
  }
  $sql .= ')';
  $stmt = $db->prepare($sql);

  foreach($records as $record) {
    $stmt->execute($record);  # should this be tried?
  }

  $db = null;
  echo "<div id='adMessages'>{$name} table successfully created.</div>";
}

