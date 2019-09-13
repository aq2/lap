<?php

require_once('db_functions.php');

// delete db if already exists, getDB() will create it when needed
$db_file = '../../data/aym.sqlite';
if (file_exists($db_file)) {
  unlink($db_file);
  gecho("$db_file deleted");
}

// create and populate new studios table
$columns = ['st_id', 'studio', 'address', 'mapRef'];
$schema = ['INTEGER PRIMARY KEY', 'TEXT NOT NULL UNIQUE', 'TEXT NOT NULL', 'TEXT'];
$records = [
  ['Lotus Loft Yoga Centre', '25 Southernhay East, Exeter', '!1m18!1m12!1m3!1d2525.8342564783893!2d-3.5261599999999653!3d50.723014000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43db07c12b7%3A0x7cc3e5bad826796d!2sLotus+Loft!5e0!3m2!1sen!2suk!4v1422712288800'],
  ['derekthedog Yoga Centre', '83/84 Queen St, Exeter', '!1m14!1m8!1m3!1d5051.451978693518!2d-3.5314212749199507!3d50.72502247256642!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486da43be056ab0b%3A0x9431c90b86e7d057!2sDerekthedog+Yoga+Centre!5e0!3m2!1sen!2suk!4v1422711334901'],
  ['Hunger Hill Yurts', 'Newton Poppleford, Sidmouth', '!1m18!1m12!1m3!1d96285.95364073697!2d-3.3628547408609584!3d50.64191093906292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486d9ea450520d97%3A0xe9396096ca54de57!2sHunger+Hill+Yurts!5e0!3m2!1sen!2suk!4v1563455133627!5m2!1sen!2suk'],
];
initTable('studios', $columns, $schema, $records);

// create workshop table
$columns = ['ws_id', 'date', 'time', 'studio_id', 'type'];
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


// construct a table called $name using da data
function initTable($name, $cols, $schema, $rows) {
  $create = "CREATE TABLE {$name} (";
  $vals_str = 'VALUES (';   # needed for INSERT statement
  $cols_str = '(';          # needed for INSERT statement

  // 'parse' parameters so we can use them in prepared SQL statements
  foreach ($cols as $index=>$col) {
   	$create .= "{$cols[$index]} {$schema[$index]}, ";

    // don't insert into first column, assume first col is always auto-incremented PK id
    if ($index > 0) {
      $vals_str .= '?, ';
      $cols_str .= $cols[$index] . ',';
    }
  }

  // create the table
  $sql = tidy($create);
  squery($sql);

  // prepare out insert statements with positional ? params values
  // TODO remove the spaces between array elements, and use implode?
  $cols_str = tidy($cols_str);
  $vals_str = tidy($vals_str);
  $sql = "INSERT INTO {$name} {$cols_str} {$vals_str}";

  // need to run prepared sql query to insert each row
  foreach ($rows as $row) {
    squery($sql, $row);
  }

  // assume it all went OK, else squery would have thrown PDO exception
  echo "<div id='adMessages'>{$name} table successfully created.</div>";
}

// TODO remove the spaces between array elements, and use implode?
// remove extraenous comma and space, and closes parentheses
function tidy($str) {
  $str = rtrim($str, ', ');
  $str .= ")";
  return $str;
}

