<?php

// safify
// check4links
// include this file in process.php's

// first of all, check honeypot for spam
if (!empty($_POST['website'])) {
  // it's SPAM
  die();
}


// sanitise user input - don't trust them!
function safify($var) {
  $var = trim($var);
  $var = strip_tags($var);
  $var = stripslashes($var);
  $var = htmlentities($var);
  return $var;
}


function checkAge($age) {
  if (($age > 10) && ($age < 100)) {
    return true;
  } else {
    return false;
  }
}


function validEmail($email) {
  return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
}

?>
