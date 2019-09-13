<?php    // controller for table_view

require_once('db_functions.php');

// echo "data posted:  ";
// print_r($_POST);  // for all GET variables

switch ($_POST['action']) {
  case 'add':
    // validate 'required'
    $fields = $_POST['form_fields'];
    $table_name = $_POST['db_table'];
    $f_arr = array_keys($fields);
    $v_arr = array_values($fields);

    // validate - make sure values arent ''
    foreach($v_arr as $v) {
      if ($v == '') {
        die('empty fields');
      }
    }
    // print_r($f_arr);
    // print_r($v_arr);

    $f_str = implode(',', $f_arr);
    $v_str = implode(',', $v_arr);
    // print_r($f_str);
    // print_r($v_str);

    // HARDCODED TODO
    $sql = "INSERT INTO $table_name ({$f_str}) VALUES ({$v_str})";
    print_r($sql);
    // squery($sql);
    $db = getDB();
    $db->query($sql);

    break;
}


// delete -> eg delete1 -> id = 1
// delete('studios', id)

// moar -> moar1
// show moar -> workshops here

// add new studio
// add('studios', [prepared params])





// cancel add studio
// cancel() -> wipes input boxes
