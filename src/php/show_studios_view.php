<?php
  require_once('db_functions.php');

  $table = getTable('studios');
  $cols = $table['cols'];
  $rows = $table['rows'];
?>

<table class='show'>
  <col style='width:6%'>
  <col style='width:25%'>
  <col style='width:30%'>
  <col style='width:15%'>
  <col style='width:21%'>
  <thead>
    <tr>
      <?php
        foreach ($cols as $col) {
          echo "<th class='{$col}'>{$col}</th>";
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
            echo "<{$tag} class='{$cols[$i]}' id='r{$j}c{$i}'>{$datum}</{$tag}>";
            $i++;   # move onto next cell
          }
          echo "<th class='but'>";
          echo "<button class='delete' id='del{$j}'>delete</button>";
          echo "<button class='moar' id='moar{$j}'>moar</button>";
          // echo "<input type='submit' value='delete' name='delete{$j}'>";
          // echo "<input type='submit' value='moar' name='moar{$j}'>";
          echo "</th></tr>";
          $j++;   # move on to next row
        }
        echo "<tr class='input'>";
        echo "<th>{$j}</th>";
      ?>
      <th><input type='text' name='st_name' required placeholder='add new studio...'></th>
      <th><input type='text' name='st_address' required ></th>
      <th><input type='text' name='st_mapRef' required ></th>
      <th>
        <button id='cancel'>cancel</button>
        <button id='add'>add</button>
      </th>
    </tr>
  </tbody>
</table>


