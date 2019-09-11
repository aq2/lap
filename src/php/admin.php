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

<div id='adminBtnsDiv'>
  <div id='showBtnsDiv'>
    <?php     # show button for each table
      foreach ($tables as $table) {
        echo "<button id='{$table}' class='showBtn'>{$table}</button>";
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
  main()

  function main() {
    setClickHandler('#initBtn', 'init_db.php', '#showDiv')

    // add click handlers to showBtns
    $('.showBtn').click( function() {
      $('#showDiv').load('/php/table_view.php?tableName=' + this.id)
      // TODO need to pass custom col widths here, and custom sql?
      // $('#showDiv').load('/php/table_view.php?tableName=' + this.id)
    })
  }

  // TODO this function only called once!
  // when button clicked, load url into div
  function setClickHandler(button, url, div) {
    $(button).click( () => {
      $(div).load('/php/' + url)
    })
  }

  // $('.showBtn').click( ()=> {
  //   // $.post('/php/table_view.php', { tableName: this.id })
  //   $.post('/php/table_view.php', { tableName: this.id }, (data) => {})
  // })

  // alert('jungle')

</script>
