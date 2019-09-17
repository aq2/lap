<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
</head>
<body>

<?php    ## admin.php => view and controller!
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
    <button id='initBtr'>inir database</button>
    <button id='initBtt'>inir database</button>
  </div>
</div>

<div id='showDiv'>
  <p>eventually show tables metadata in here</p>
</div>

<div id='messagesDiv'>
  <p>messages to go here</p>
</div>


<!-------------------------------------------
    insert javscript 'controller' here
-------------------------------------------->
<script src='/js/functions.js'></script>
<script>
  bling()
  main()

// addEventListeners to the buttons
function main() {
  // need to use callHack trick to send arguments
  // document.getElementById('initBtn')
  $('#initBtn')
    .addEventListener('click', callHack('/admin/init_db_view.html', 'showDiv'))

  $('.showBtn').on('click', function() {
    loadDoc2('/admin/table_view.php?' + this.id, 'showDiv')
  })
}    // end main()



// need to use callHack trick to send arguments
function callHack(url, div) {
  return function() {
    url2Div(url, div)
    // loadDoc(url, div)
  }
}


function url2Div(url, div) {
  fetch(url)
    .then(response => response.text())
    .then(html => {document.getElementById(div).innerHTML = html})
    .catch(err => console.log(err))
}



</script>

