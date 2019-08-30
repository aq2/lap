<?php  // initialise new database

require_once('functions.php');

// destroy database if already exists, and start afresh
$db_file = '../data/aym.sqlite';
if (file_exists($db_file)) {
  unlink($db_file);
}

/* $db = new SQLite3($db_file); */

/* // create table and insert data */
/* $sql = "CREATE TABLE 'studios' ('st_name' TEXT PRIMARY KEY, 'address' TEXT)"; */
/* squery($sql, 'create DB'); */

/* $sql = "INSERT INTO 'studios' ('st_name', address) VALUES ('Lotus Loft', 'Queen St');" */
/*      . "INSERT INTO 'studios' ('st_name', address) VALUES ('derekthedog', 'Barking');"; */
/* squery($sql, 'insert values'); */

// now let's use PDO
try {
  $db = new PDO('sqlite:' . $db_file);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // create table and insert data */
  $sql = "CREATE TABLE 'studios' ('st_name' TEXT PRIMARY KEY, 'address' TEXT)";

  // use exec as no results returned
  $db->exec($sql);

  // add some entries

  $sql = "INSERT INTO 'studios' ('st_name', 'address') VALUES ('Lotus Loft', 'Queen St');";
  $db->exec($sql);

  $sql = "INSERT INTO 'studios' ('st_name', 'address') VALUES ('derekthedog', 'Barking');";
  $db->exec($sql);

  $st1n = 'Hunger';
  $st1a = 'Newton Pop';
  $sql0 = "INSERT INTO 'studios' ('st_name', 'address') VALUES ('" . $st1n . "', '" . $st1a . "');";
  echo $sql0;
  $db->exec($sql0);

} catch(PDOException $ex) {
  echo $ex->getMessage();
  die('database problemo');
}




/* squery($sql, 'create DB'); *1/ */



?>
