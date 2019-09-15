<?php   // admin buttons, view and controller!)
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

<script>
  main()

  function main() {
    // setClickHandler('#initBtn', 'init_db.php', '#showDiv')

    $('#initBtn').click( function() {
      $(location).attr('href', '/admin/init_db_view.php');
    })

    // add click handlers to showBtns
    $('.showBtn').click( function() {
      $(location).attr('href', '/admin/table_view.php?tableName=' + this.id);
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
