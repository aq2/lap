<?php    // controller for table_view

require_once('db_functions.php');

// echo "data GETed:  ";
// print_r($_GET);


if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'add':    # normal form handling here for adding new records
      $f_arr = array_keys($_GET);
      $v_arr = array_values($_GET);

      // last element is unnecessary - it's a hidden field action -> add
      $nope = array_pop($f_arr);
      $nope = array_pop($v_arr);

      // next last element is hidden field for 'table' -> db table name
      $nope = array_pop($f_arr);
      $table_name = array_pop($v_arr);

      // add quotes to form values
      foreach ($v_arr as $v) {
        $qv_arr[] = '"' . $v . '"';
      }

      // change arrays to strings
      $f_str = implode(',', $f_arr);
      $v_str = implode(',', $qv_arr);

      // do db stuff
      $sql = "INSERT INTO $table_name ({$f_str}) VALUES ({$v_str})";
      $db = getDB();
      $db->query($sql);
      $db = null;

      // refresh page
      $goto = '/admin/table_view.php?tableName=' . $table_name;
      header('Location: ' . $goto);

      break;

    case 'delete':    # delete a record
      $but_id = $_GET['id'];
      $row_id = ltrim($but_id, 'del');
      $table = $_GET['table'];

      switch ($table) {
        case 'studios':
          $id_field = 'st_id';
          break;
        case 'workshops':
          $id_field = 'ws_id';
          break;
      }

      $sql = "DELETE FROM $table WHERE $id_field = {$row_id}";
      $db = getDB();
      $db->query($sql);
      $db = null;

      // refresh page
      $goto = '/admin/table_view.php?tableName=' . $table_name;
      header('Location: ' . $goto);

// moar -> moar1
// show moar -> workshops here

// add new studio
// add('studios', [prepared params])


// cancel add studio
// cancel() -> wipes input boxes

    }   # end switch
}   # end if
