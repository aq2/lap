<?php
  require_once('db_functions.php');

  // also need to GET column widths array

  $tableName = $_GET['tableName'];
  $table = getTable($tableName);
  // TODO $table = getTable($tableName, customSQL);
  $cols = $table['cols'];
  $rows = $table['rows'];
?>

<table class='show'>
  <col style='width:6%'> <!-- hardcoded! -->
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

