<?php    # useful database functions - could wrap them into an object?

// try to return the database, default is aym.sqlite
function getDB($db_file = '../../data/aym.sqlite') {
  try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
  } catch(PDOException $ex) {
    echo $ex->getMessage();
    die("<br>sorry - problem with getting database $db_file <br>");
  }
}


// returns database table names as an array
function getTableNames() {
  $sql = "SELECT * FROM sqlite_master WHERE type='table'";
  $results = squery($sql);
  foreach ($results as $tbl) {
    $tables[]  = $tbl['name'];
  }
  return $tables;
}


// executes raw $sql, or prepared paramateredised statement
// TODO add try/catch to distinguish between getDB() and sql errors?
// returns results of query for SELECT's
function squery($sql, $paramsArray=[]) {
  $db = getDB();
  $stmt = $db->prepare($sql);
  $stmt->execute($paramsArray);   # try/catch this?
  $results = $stmt->fetchAll();

  $db = null;   # don't need objects anymore, clear them
  $stmt = null;
  return $results;
}


// returns contents of db table as $table->$rows and $cols
// TODO add custom sql option - can pass in a more complex query
// function getTable($tableName, $sql="SELECT * FROM {$tableName}") {
function getTable($tableName, $sql) {
  $results = squery($sql);

  if (!empty($results)) {
    foreach ($results as $row) {
      $rows[] = array_values($row);
    }
    $cols = array_keys($results[0]);  # only need to do this once, not in foreach
  }

  $table = array('rows' => $rows, 'cols' => $cols);
  return $table;
}


// need new fns here that call squery
// addRecord($table, [$prepd statement data])
// deleteRecord($table, $id)
// moar() - specialised for each table, stick it controller
// cancelAdd() - not really a db function, more a shared controller fn


sdsadsadsadsad
// my 'debuggers'
function gecho($desc, $var='') {
  echo "<br>{$desc}: {$var}<br>";
}
// for arrays and objects
function recho($desc, $arr) {
  echo "<pre><br>{$desc}: ";
  print_r($arr);
  echo "<br></pre>";
}

