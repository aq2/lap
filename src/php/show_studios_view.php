<?php
  require_once('db_functions.php');
  require_once('admin_buttons.php');

  $table = getTable('studios');
  $cols = $table['cols'];
  $rows = $table['rows'];
?>

<table class='show'>
  <tr>
    <?php
      foreach ($cols as $col) {
        echo "<th class='{$col}'>{$col}</th>";
      }
    ?>
  </tr>
  <?php
    foreach ($rows as $row) {
      $i = 0;
      echo "<tr>";
      foreach ($row as $datum) {
        echo "<td class='{$cols[$i]}'>{$datum}</td>";
        $i++;
      }
      echo "</tr>";
    }
  ?>
</table>



