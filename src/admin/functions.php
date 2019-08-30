<?php
// bunch of useful functions worth requiring for admin stuff


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

?>
