<?php

require_once('db_functions.php');

$tableName = $_GET['tableName'];
switch ($tableName) {
  case 'studios':
    $sql = "SELECT * FROM studios";
    $col_widths = [6, 25, 30, 15, 21];
    break;
  case 'workshops':
    $sql = "SELECT w.ws_id, w.date, w.time, w.type, s.name
            FROM workshops w, studios s
            WHERE w.studio_id = s.st_id";
    $col_widths = [5, 18, 8, 10, 20, 18];
    $specialColumns = [3 => 'workshops', 4 => 'studios'];
    $specialNumbers = array_keys($specialColumns);
    break;
}

$table = getTable($tableName, $sql);
$cols = $table['cols'];
$rows = $table['rows'];

if (isset($specialColumns)) {
  $rows = injectSelect($rows, $cols, $specialColumns)[0];
  $selects = injectSelect($rows, $cols, $specialColumns)[1];
}


// foreach special, build select string, then inject into rows[x]
// TODO a bit of a mess?
function injectSelect($rows, $cols, $specialColumns) {
  $selects = [];
  foreach ($specialColumns as $col_num => $table) {
    $fieldName = $cols[$col_num];
    $sql = "SELECT DISTINCT $fieldName FROM {$table}";
    $results = squery($sql);
    $options = [];
    foreach ($results as $k => $option) {
      $options[] = $option[$fieldName];
    }
    $select_html = makeSelectString($options, $fieldName);
    $selects[] = $select_html;
    foreach ($rows as $key => $row) {
      $rows[$key][$col_num] = $select_html;
    }
  }
  return [$rows, $selects];
}


function makeSelectString($options, $field) {
  $html = "<select name={$field}>";
  foreach ($options as $option) {
    $html .= "<option value={$option}>{$option}</option>";
  }
  $html .="</select>";
  return $html;
}

?>


<table class='show'>
  <?php
    foreach ($col_widths as $width) {
      echo "<col style='width:{$width}%'>";
    }
  ?>
  <thead>
    <tr>
      <?php
        foreach ($cols as $col) {
          echo "<th>{$col}</th>";
        }
      ?>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $j = 1;   # refers to row number - ie id
      foreach ($rows as $row) {
        $i = 0;
        echo "<tr>";
        foreach ($row as $datum) {
          $tag = ($i==0 ? 'th':'td');   # id column should be a th -> uneditable
          echo "<{$tag} id='r{$j}c{$i}'>{$datum}</{$tag}>";
          $i++;   # move onto next cell
        }
        echo "<th>";
        echo "<button id='del{$j}'>delete</button>";
        echo "<button id='moar{$j}'>moar</button>";
        echo "</th></tr>";
        $j++;   # move on to next row
      }

      // now add input fields for adding new record
      echo "<tr class='input'>";
      echo "<th>{$j}</th>";

      $num_cols = count($cols);
      for ($c=1; $c<$num_cols; $c++) {
        if (isset($specialNumbers) && in_array($c, $specialNumbers)) {
          $html = array_shift($selects);
          echo "<th id='new{$c}'>{$html}</th>";
        } else {
          echo "<th><input id=new{$c}' type='text' name={$col} required placeholder='add new {$tableName}'></th>";
        }
      }
    ?>

      <th>
        <button id='cancel' onclick='cancelAdd()'>cancel</button>
        <button id='add' onclick='add()'>add</button>
      </th>
    </tr>
  </tbody>
</table>

<script>
  // should these be two be in controller - or at least call a controller fn?
  function cancel() {}
  function add() {}

  function assignClickHandlers() {
    // cells
    // delete
    // moar
    // add fresh
    // cancel fresh
    // they all post something to controller
  }



</script>
