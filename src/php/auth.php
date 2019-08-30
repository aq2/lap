<?php

require_once('validators.php');
require_once('functions.php');

// process form to check password
// TODO add saghar user
$form_name = $_POST['name'];
$form_password = $_POST['password'];


// check password against ini file
$ini = parse_ini_file('conf.ini.php');

if ( ($form_password == $ini['password1'])
      && ($form_name == $ini['user1'])) {

  // ok start session and transfer to admin.php
  session_start();
  $_SESSION['name'] = $form_name;
  $_SESSION['password'] = $form_password;
  $_SESSION['loggedin'] = true;

  echo "<meta http-equiv='refresh' content='0; URL=../admin/admin.php'>";
  exit;

} else {
  destroy_session_and_data();
  echo 'nope';
}


?>
