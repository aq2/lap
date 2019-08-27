<?php
// bunch of useful functions worth requiring for mysql and sessions

/* $connection = new mysqli */


function createTable($name, $query) {
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query) {
  global $connection;
  $result = $connection->query($query);
  if (!$result) {
    die($connection->error);
  }
  return $result;
}



function destroy_session_and_data() {
  session_start();
  $_SESSION = array();
  setcookie(session_name(), '', time() - (60 * 60 * 24), '/');
  session_destroy();
}

?>
