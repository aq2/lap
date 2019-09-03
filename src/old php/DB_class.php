<?php

class DB {
  public $name;
  public $tables;
  public $handler;   // ?


  // no constructor needed ?
  public function __construct($file = '../../data/aym.sqlite') {
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

  public function createTable($name, $cols, $schema, $records) {}

  public function getTableNames() {}

  public function getTable($name) {}

  public function wipeTable ($name) {}


}
