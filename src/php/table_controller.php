<?php    // controller for table_view

require_once('db_functions.php');

// echo "data posted:  ";
print_r($_POST);

// add normal form handling here!



if (isset($_POST['action'])) {
switch ($_POST['action']) {
  case 'add':
    $fields = $_POST['form_fields'];
    $table_name = $_POST['db_table'];

    // validate - make sure values are set
    foreach($fields as $f) {
      gecho('f: ', $f);
      if ($f == "") {
        die('empty fields');
      }
    }

    $f_arr = array_keys($fields);
    $v_arr = array_values($fields);
    // print_r($v_arr);
    // print_r($f_arr);

    // validate - make sure values are set
    foreach($v_arr as $v) {
      if (!isset($v)) {
        die('empty fields');
      }
    }

    $f_str = implode(',', $f_arr);
    $v_str = implode(',', $v_arr);
    // print_r($f_str);
    // print_r($v_str);

    $sql = "INSERT INTO $table_name ({$f_str}) VALUES ({$v_str})";
    print_r($sql);
    // squery($sql);
    $db = getDB();
    $db->query($sql);

    break;
}
}


// delete -> eg delete1 -> id = 1
// delete('studios', id)

// moar -> moar1
// show moar -> workshops here

// add new studio
// add('studios', [prepared params])





// cancel add studio
// cancel() -> wipes input boxes
