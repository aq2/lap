<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
</head>

<body>

<?php

require_once('admin_buttons.php');
require_once('table_controller.php');
require_once('db_functions.php');



if (isset($_GET['tableName'])) {
  $tableName = $_GET['tableName'];
  showTable($tableName);
}


function showTable($table) {
  // $table = $_GET['tableName'];
  switch ($table) {
    case 'studios':
      $sql = "SELECT * FROM studios";
      $col_widths = [6, 25, 30, 15, 21];
      break;
    case 'workshops':
      $sql = "SELECT w.ws_id, w.date, w.time, w.type, s.studio
              FROM workshops w, studios s
              WHERE w.studio_id = s.st_id";
      $col_widths = [5, 18, 8, 10, 20, 18];
      $specialColumns = [3 => 'workshops', 4 => 'studios'];
      $specialNumbers = array_keys($specialColumns);
      break;
  }

  $tableData = getTable($table, $sql);
  $cols = $tableData['cols'];
  $rows = $tableData['rows'];

  if (isset($specialColumns)) {
    // $rows = injectSelect($rows, $cols, $specialColumns)[0];
    $selects = injectSelect($rows, $cols, $specialColumns)[1];
  }

  // start html buffer
  ob_start();
  ?>

  <h1> <?= $table ?> </h1>

  <!-- can't put form in table -->
  <form action='/admin/table_controller.php' method='GET' id='add'>

  <table class='show' id=<?= $table ?>>
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
        $j = 1;   # refers to row number, not necess the id
        $id = 'nope';
        foreach ($rows as $row) {
          $i = 0;
          echo "<tr>";
          foreach ($row as $datum) {
            $tag = 'td';
            if ($i == 0) {  # id column
              $tag = 'th';
              $id = $datum;
            }
            echo "<{$tag} id='r{$j}c{$i}'>{$datum}</{$tag}>";
            $i++;   # move onto next cell
          }
          echo "<th>";
          echo "<button id='del{$id}' class='del' form='no'>delete</button>";
          echo "<button id='moar{$id}' class='moar' form='no'>moar</button>";
          echo "</th></tr>";
          $j++;   # move on to next row
        }

        // now we need the input boxes for adding new record
        echo "<tr class='input'>";
        echo "<th>{$j}</th>";

        $num_cols = count($cols);
        for ($c=1; $c<$num_cols; $c++) {
          if (isset($specialNumbers) && in_array($c, $specialNumbers)) {
            $html = array_shift($selects);
            echo "<td id='new{$c}'>{$html}</td>";
          } else {
            echo "<th><input id='new{$c}' type='text' name={$cols[$c]}
                  form='add' required placeholder='add new...'></th>";
          }
        }
      ?>

        <th>
          <input type='hidden' form='add' name='table' value=<?= $table ?>>
          <input type='hidden' form='add' name='action' value='add'>
          <input type='reset' form='add' value='cancel'>
          <input type='submit' form='add' value='add'>
        </th>
      </tr>
    </tbody>
  </table>
  </form>

  <?php

  // end html buffer and echo it out
  $myhtml = ob_get_clean();
  echo $myhtml;
}


// foreach special, build select string, then inject into rows[x]
// TODO check out js replace() function!
// TODO a bit of a mess?
// TODO DON'T INJECT! - only into last row, or onclick
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
    // TODO value shiould be index? eg 1,2 or 3 rather than option value
    // TODO mark which one is selected - need to rethink a bit
    $html .= "<option value={$option}>{$option}</option>";
  }
  $html .="</select>";
  return $html;
}

?>



<!-------------------------------------------
    insert javascripts here
-------------------------------------------->
<script>
  assignClickHandlers()

  function assignClickHandlers() {
    // they all GET something to controller
    const cont_url = '/admin/table_controller.php'

    // cells
    $('td').click( function() {
      // change style -> change to input or editable div?
      // is it a special? -> change to select
      // another click handler for enter keypress?
      $.get(cont_url, { action: 'edit',
                         id: this.id },
        function(data) {console.log(data)})
    })


    // delete
    $('.del').click( function() {
      table =  $('.show').attr('id')
      $.get(cont_url, { action: 'delete',
                         id: this.id,
                         table: table },
        function(data) { console.log(data)
                         $.post('/php/table_controller.php?tableName=' + table)
                       }
    )})

    // moar
    $('.moar').click( function() {
      $.get(cont_url, { action: 'moar',
                         id: this.id },
        function(data) {console.log(data)})
    })

  }



</script>
