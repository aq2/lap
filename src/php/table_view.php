<?php
main();

function main() {
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

      $results = squery('SELECT DISTINCT type FROM workshops');
      $types = array();
      foreach ($results as $type) {
        $types[] = $type['type'];
      }

       $types = getOptions('SELECT DISTINCT type FROM workshops', 'type');
      // $studios = getOptions('SELECT name FROM studios', 'name');

      $coltypes = [4 => $types, 5 => $studios];
      break;
  }



  $table = getTable($tableName, $sql);
  $cols = $table['cols'];
  $rows = $table['rows'];
}

  // merge this fn with makeSelectString
  function getOptions($sql, $field) {
    $options = array();
    $results = squery($sql);
    foreach ($results as $option) {
      // recho('opt', $option);
      // gecho('g', $option[$field]);
      $options[] = $option[$field];   # don't work - syntax error unexpected {
    }
    recho('opt', $options);
    return $options;
  }

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

        // TODO a bit hacky?
        $k = 0;   # don't want first id column
        foreach ($cols as $col) {
          if ($k > 0) {
            echo "<th><input type='text' name={$col} required placeholder='add new {$tableName}'></th>";
          }
          $k++;
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

