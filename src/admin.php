<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
  <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
</head>

<body>

<?php
  require_once('db_functions.php');
  $tables = getTableNames();
?>

<div id='adBtnsDiv'>
  <div id='showBtnsDiv'>
    <?php     # show button for each table
      foreach ($tables as $table) {
        echo "<button id='{$table}Btn' class='showBtn'>{$table}</button>";
      }
    ?>
  </div>
  <div id='initBtnDiv'>
    <button id='initBtn'>init database</button>
  </div>
</div>

<div id='showDiv'>
  <p>eventually show tables metadata in here</p>
</div>


<script>

  setClickHandler('#initBtn', 'init_db.php', '#showDiv')

  // $('#studiosBtn').click( () => {
  //   $.post('/php/table_view', { tableName: 'studios' })
  // })

  $('.showBtn').click( ()=> {
    $.post('/php/table_view.php', { tableName: this.id })
  })

  // when button clicked, load url into div
  function setClickHandler(button, url, div) {
    $(button).click( () => {
      $(div).load('/php/' + url)
    })
  }

  alert('jungle')

</script>
