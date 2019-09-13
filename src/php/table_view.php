<?php

require_once('db_functions.php');

$tableName = $_GET['tableName'];
switch ($tableName) {
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

$table = getTable($tableName, $sql);
$cols = $table['cols'];
$rows = $table['rows'];

if (isset($specialColumns)) {
  // $rows = injectSelect($rows, $cols, $specialColumns)[0];
  $selects = injectSelect($rows, $cols, $specialColumns)[1];
}


// foreach special, build select string, then inject into rows[x]
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


  <table class='show' id=<?= $tableName ?>>
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
          $tag = ($i==0 ? 'th':'td');   # id column should be uneditable th
          echo "<{$tag} id='r{$j}c{$i}'>{$datum}</{$tag}>";
          $i++;   # move onto next cell
        }
        echo "<th>";
        echo "<button id='del{$j}' class='delete'>delete</button>";
        echo "<button id='moar{$j}' class='moar'>moar</button>";
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
          echo "<td id='new{$c}'>{$html}</td>";
        } else {
          echo "<td><input class='inp' id='new{$c}' type='text' name={$cols[$c]}
                required placeholder='add new {$tableName}'></td>";
        }
      }
    ?>

      <th>
        <button id='cancel'>cancel</button>
        <button id='add'>add</button>
      </th>
    </tr>
  </tbody>
</table>

<script>
  assignClickHandlers()

  function assignClickHandlers() {
    // they all post something to controller
    const cont_url = '/php/table_controller.php'

    // cells
    $('td').click( function() {
      // change style -> change to input or editable div?
      // is it a special? -> change to select
      // another click handler for enter keypress?
      $.post(cont_url, { action: 'edit',
                         id: this.id },
        function(data) {console.log(data)})
    })


    // delete
    $('.delete').click( function() {
      $.post(cont_url, { action: 'delete',
                         id: this.id },
        function(data) {console.log(data)}
    )})

    // moar
    $('.moar').click( function() {
      $.post(cont_url, { action: 'moar',
                         id: this.id },
        function(data) {console.log(data)})
    })

    // add fresh
    $('#add').click( function() {
      let form_fields = {}

      $('.input').find('input, select')
                 .each( function() {
                   form_fields[this.name] = '"' + this.value + '"'
      })

      const table_name = $('table').attr('id');

      // TODO should validate for empty inputs here rather than php on server...
      $.post(cont_url, { action: 'add',
                         db_table: table_name,
                         form_fields: form_fields
                        },
        function(data) {console.log(data)}
    )})


    // input type=reset - only works in a form?
    // cancel fresh
    $('#cancel').click( function() {
      $.post(cont_url, { action: 'cancel' },
        function(data) {console.log(data)})
    })


  }



</script>
