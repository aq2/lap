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
    $col_widths = [4, 2, 1];

    // $results = squery('SELECT DISTINCT type FROM workshops');
    // $types = array();
    // foreach ($results as $type) {
    //   $types[] = $type['type'];
    // }

    //   $types = getOptions('SELECT DISTINCT type FROM workshops', 'type');
    // $studios = getOptions('SELECT name FROM studios', 'name');

    $specialColumns = [3 => 'workshops', 4 => 'studios'];
    $specialNumbers = array_keys($specialColumns);
    recho('specNum', $specialNumbers);
    break;
}


$table = getTable($tableName, $sql);
// recho('table', $table);
$cols = $table['cols'];
$rows = $table['rows'];

$rows = injectSelect($rows, $cols, $specialColumns)[0];
$selects = injectSelect($rows, $cols, $specialColumns)[1];

// recho('new_rows', $new_rows);

// foreach special, build select string, then inject into rows[x]
function injectSelect($rows, $cols, $specialColumns) {
  $selects = [];
  foreach ($specialColumns as $col_num => $table) {
    $fieldName = $cols[$col_num];
    $sql = "SELECT DISTINCT $fieldName FROM {$table}";
    $results = squery($sql);
    // recho('res', $results);
    $options = array();
    foreach ($results as $k => $option) {
      $options[] = $option[$fieldName];
    }
    // recho('opts', $options);
    $select_html = makeSelectString($options, $fieldName);
    $selects[] = $select_html;
    recho('html', $select_html);
    // $new_rows = array(array());
    foreach ($rows as $ky => $row) {
      $rows[$ky][$col_num] = $select_html;
      // recho('row', $row);
      // recho('rows', $rows);
    }
  }

      recho('selects', $selects);
     // recho('rows', $rows);
  return [$rows, $selects];
}



  // // merge this fn with makeSelectString
  // function getOptions($sql, $field) {
  //   $options = array();
  //   $results = squery($sql);
  //   foreach ($results as $option) {
  //     // recho('opt', $option);
  //     // gecho('g', $option[$field]);
  //     $options[] = $option[$field];   # don't work - syntax error unexpected {
  //   }
  //   recho('opt', $options);
  //   return $options;
  // }

  function makeSelectString($options, $field) {
    // $options = ['aym', 'yoga', 'int']
    $html = "<select name={$field}>";
    foreach ($options as $option) {
      $html .= "<option value={$option}>{$option}</option>";
    }
    $html .="</select>";
    // replace $cols[x] with $html?
    return $html;
  }

?>

<table class='show'>
  <!-- loop through column $widths -->
  <col style='width:6%'>
  <col style='width:25%'>
  <col style='width:30%'>
  <col style='width:15%'>
  <col style='width:21%'>
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
          if (in_array($c, $specialNumbers)) {
            $html = array_shift($selects);
            echo "<th>{$html}</th>";
          } else {
            echo "<th><input type='text' name={$col} required placeholder='add new {$tableName}'></th>";
          }
        }

      ?>

      <th>
        <!-- TODO need clickhandlers -->
        <button id='cancel'>cancel</button>
        <button id='add'>add</button>
      </th>
    </tr>
  </tbody>
</table>

