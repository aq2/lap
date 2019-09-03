<?php  // show list of studios

require_once('functions.php');
// checkIfSession();

$db = getDB();
$sql = "SELECT * FROM 'studios'";
$result = $db->query($sql);


// should iterate over all columns rather than harcode da fucker
// while ($row = $result->fetch(PDO::FETCH_BOTH)) {
  // echo $row['name'] . "    " .  $row['address'] . "<br>";
// }


while ($row = $result->fetch()) {
  echo $row->name . "    " .  $row->address . "<br>";
}
newLines(5);


