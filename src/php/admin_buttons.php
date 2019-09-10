<?php   # button view and controller

require_once('db_functions.php');
$tables = getTableNames();
// echo "<script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>";
?>

<div id='adBtnsDiv'>
  <div id='showBtnsDiv'>
    <?php     # show button for each table
      foreach ($tables as $table) {
        echo "<button id='{$table}Btn')'>{$table}</button>";
      }
    ?>
  </div>
  <div id='initBtnDiv'>
    <button id='initBtn'>init database</button>
  </div>
</div>


<script>
setClickHandler('#initBtn', 'init_db.php', '#showDiv')

$('#studiosBtn').click( () => {
  $.post('/php/table_view', { tableName: 'studios' })
})

// when button clicked, load url into div
function setClickHandler(button, url, div) {
  $(button).click( () => {
    $(div).load('/php/' + url)
  })
}
    alert('jungle')

</script>
