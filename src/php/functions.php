<?php
// bunch of useful functions worth requiring for admin stuff


function getDB($db_file = '../data/aym.sqlite') {
  # try to return the database, default is aym.sqlite
  try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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


function checkIfSession() {
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    die("shouldn't be here");
  }
}

function destroy_session_and_data() {
  session_start();
  $_SESSION = array();
  setcookie(session_name(), '', time() - (60 * 60 * 24), '/');
  session_destroy();
}

// do a sqlite query, and report back
function squery($sql, $action) {
  $db = new SQLite3('../data/aym.sqlite');

  if ($db) {
    $db->query($sql);
    echo "$action OK <br>";
    // call js function?
  } else {
    echo "$action nope! <br>";
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



?>
