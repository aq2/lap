<?php

// try to return the database, default is aym.sqlite
function getDB($db_file = '../../data/aym.sqlite') {
  try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); # or FETCH ASSOC, can override
    return $db;
  } catch(PDOException $ex) {
    echo $ex->getMessage();
    die("<br>sorry - problem with getting database $db_file <br>");
  }
}


// returns $results from an $sql query
function squery($sql) {
  $db = getDB();
  $results = $db->query($sql);
  $db = null;
  return $results;
}


# TODO these functions look very similar!

// returns database table names as an array
function getTableNames() {
  $tables = array();
  $sql = "SELECT * FROM sqlite_master WHERE type='table'";
  $results = squery($sql);
  while ($row = $results->fetch()) {
    $tables[] = $row->name;    # array_push($tables, $table_name)
  }
  return $tables;
}


// returns array of column names
function getColumnNames($tableName) {
  $cols = array();
  $sql = "PRAGMA table_info({$tableName})";
  $results = squery($sql);
  while ($row = $results->fetch()) {
    $cols[] = $row->name;
  }
  return $cols;
}


// return $records array of table rows
function getRecords($tableName) {
  $records = array();
  $sql = "SELECT * FROM {$tableName}";
  $results = squery($sql);
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    $records[] = array_values($row);
  }
  return $records;
}


// my 'debuggers'
function gecho($desc, $var) {
  echo "<br>{$desc}: {$var}<br>";
}
// for arrays and objects
function recho($desc, $arr) {
  echo "<pre><br>{$desc}: ";
  print_r($arr);
  echo "<br></pre>";
}


?>
