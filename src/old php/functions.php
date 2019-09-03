<?php
// bunch of useful functions worth requiring for admin stuff


function getDB($db_file = '../../data/aym.sqlite') {
  # try to return the database, default is aym.sqlite
  try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // or FETCH ASSOC, can override
    return $db;
  } catch(PDOException $ex) {
    echo $ex->getMessage();
    die('sorry - problem with database <br>');
  }
}

function newLines($n = 1) {
  for ($i=0; $i<=$n; $i++) {
    echo '<br>';
  }
}


// converts [k1=>v1,k2=>v2] to [(k1,k2), (v1,v2)]
function assoc2kv($assoc) {
  $keys = array();
  $vals = array();
  foreach($assoc as $k => $v) {
    $keys[] = $k;
    $vals[] = $v;
  }
  return [$keys, $vals];
}


// returns database table names as an array
function getTableNames() {
  $db = getDB();
  $sql = "SELECT * FROM sqlite_master WHERE type='table';";
  $tables = $db->query($sql);

  return $tables;
}
?>
