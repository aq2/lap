<?php    // controller for table_view

require_once('db_functions.php');

echo "data posted:  ";
print_r($_POST);  // for all GET variables

switch ($_POST['action']) {
  case 'add':
    echo "<br>add data<br>";
    // validate 'required'
    $fields = $_POST['form_fields'];
    recho('ff', $fields);
    foreach ($fields as $k=>$v) {
      echo $k, $v;
    }
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
