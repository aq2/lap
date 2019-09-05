<?php  // show html table of db table

require_once('db_functions.php');
require_once('admin_buttons.php');

$table_name = $_GET['table'];

$cols = getColumnNames($table_name);
$rows = getRecords($table_name);

// recho('cols', $cols);
// recho('rows', $rows);

?>

<table>
  <tr>
    <?php
      foreach ($cols as $col) {
        echo "<th>{$col}</th>";
      }
    ?>
  </tr>
  <?php
    foreach ($rows as $row) {
      echo "<tr>";
      foreach ($row as $datum) {
        echo "<td>{$datum}</td>";
      }
      echo "</tr>";
    }
  ?>
</table>


