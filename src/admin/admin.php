<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
<script src='/js/functions.js'></script>
 </head>

<body>

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

<div id='showDiv'>
  <p>eventually show tables metadata in here</p>
</div>

// <?php
//   // start js buffer
//   ob_start();
// ?>

<script>
alert('admin in js 3')
bling()
main()


// addEventListeners to the buttons
function main() {
  alert('main')
  document.getElementById('initBtn').addEventListener('click', loadDoc4('/admin/init_db_view.php', 'showDiv'))

  $('.showBtn').on('click', function() {
    loadDoc2('/admin/table_view.php?' + this.id, 'showDiv')

  })
}
// end main()


function loadDoc2(url, div) {
  // load url into DOM element, ask for confirmation if confirmMsg
  // el is div name without #
    alert('loadDoc2 ' + url + ' ' + div)
    // var xhr = new XMLHttpRequest()
    // xhr.onreadystatechange = function() {
    //   if (this.readyState == 4 && this.status == 200) {
    //     alert('ajax ')
    //     document.getElementById(divID).innerHTML = this.responseText

    //   }
    // xhr.open('GET', url, true)

    // xhr.send()
    
    fetch(url)
      .then((res) => {
                      alert(res)
                      res.text()
                      })
      .then((data) => {console.log(data)})

  }



function loadDoc4(url, div) {
  return function() {
    alert('loadDoc4 ' + url + ' ' + div)
    loadDoc2(url, div)
  }
}


function callback(a, b) {
  return function() {
    console.log(`sum = ${a+b}`)
  }
}

function loadDoc3() {
  alert('all the 3s')
}

</script>



// <?php
//   $myjs = ob_get_clean();
// echo $myjs;
