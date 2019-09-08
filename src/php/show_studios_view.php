<?php
  require_once('db_functions.php');
  require_once('admin_buttons.php');

  $table = getTable('studios');
  $cols = $table['cols'];
  $rows = $table['rows'];
?>

<form action='studios_controller.php'>
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
        foreach ($rows as $row) {
          $i = 0;
          $j = 1;   # refers to row number - ie id
          echo "<tr>";
          foreach ($row as $datum) {
            echo "<td class='{$cols[$i]}'>{$datum}</td>";
            $i++;
          }
          echo "<td class='but'>";
          echo "<input type='submit' value='delete' name='delete{$j}'>";
          echo "<input type='submit' value='moar' name='moar{$j}'>";
          echo "</td></tr>";
          $j++;
        }
      ?>
    </tbody>
  </table>
</form>


