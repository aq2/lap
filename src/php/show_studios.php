<?php  // show list of studios

require_once('functions.php');
// checkIfSession();

echo 'studios<br><br>';

$db = new SQLite3('../data/aym.sqlite');

$sql = "SELECT * FROM 'studios'";
$result = $db->query($sql);

while ($row = $result->fetchArray()) {
  echo $row['st_name'] . "    " .  $row['address'] . "<br>";
}

/* $db = sqlite_open('../data/aym.sqlite'); */
/* /1* $cols = $db->fetchColumnTypes('studios', SQLITE_ASSOC); *1/ */
/* $cols = sqlite_fetch_column_types('studios', $db, SQLITE_ASSOC); */
/* foreach ($cols as $column => $type) { */
/*   echo "column: $column  Type $type <br>"; */
/* } */



$res = $db->query("SELECT * FROM studios");

echo $res;
$col1 = $res->columnName(0);
$col2 = $res->columnName(1);

$header = sprintf("%-10s %s\n", $col1, $col2);
echo $header;

