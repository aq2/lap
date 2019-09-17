<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
</head>
<body>

<!-----------------------------------------------
    wee bit of php: get table names for buttons
------------------------------------------------>
<?php
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
    <button id='initBtr'>spacer spacer</button>
    <button id='initBtt'>spacer spacer</button>
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
  $('#initBtn').on('click',
    url2Div('/admin/init_db_view.html', 'showDiv')
  )

  $('.showBtn')
    .on('click',
      url2Div('/admin/view.matrix.html?' + this.id, 'showDiv')
    // now call a function somewhere to add clicknadlers??
  )
}


// need to use callback wrap in a function trick to use arguments
function url2Div(url, div) {
  return function() {
    fetch(url)
      .then(response => response.text())
      .then(html => {document.getElementById(div).innerHTML = html})
      .catch(err => console.log(err))
  }
}

</script>
