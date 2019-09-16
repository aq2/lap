<?php    ## admin_buttons.php => view and controller!
  require_once('db_functions.php');
  $tables = getTableNames();
?>


<!-------------------------------------------
    insert HTML 'view' here
-------------------------------------------->
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


<!-------------------------------------------
    insert javascripts here
    this is the 'controller' for the button 'view'. model is button->url relationship
-------------------------------------------->
  <script src='/js/functions.js'></script>

  <script>
  bling()  // so we can use $ selector in main
  main()

  // addEventListeners to the buttons
  function main() {
    $('#initBtn').on('click', function(ev) {
      location.replace('/admin/init_db_view.php')
    })

    $('.showBtn').on('click', function() {
      location.replace('/admin/table_view.php?tableName=' + this.id)
    })
  }
  // end main()



</script>
