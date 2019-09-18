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
<object width=800 height 800 id='myframe'>

<div id='messagesDiv'>
  <p>messages to go here</p>
</div>


<!-- <object width=800 height=800 data='/admin/view.matrix.html'> -->

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
      obi)
      // hopeless)
      // url2Body('/admin/view.matrix.html?' + this.id, 'showDiv')
      // url2Div('/admin/view.matrix.html?' + this.id, 'showDiv')
    // now call a function somewhere to add clicknadlers??
  // )
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

function url2Body(url, div) {
  return function() {
    var element = document.createElement('div')
    element.src = '/admin/view.matrix.html?studios=bob'
    alert(element)
    console.table(element)
    document.body.appendChild(element)

  }
}


// works for 'injecting' external url and scripts!
function obi() {
  var $obj = document.getElementById('myframe')
  $obj.data = '/admin/view.matrix.html'
  // $obj.outerHTML = $obj.outerHTML;
  document.getElementById('showDiv').innerHTML = $obj.outerHTML

}

function obi1() {
  var div = document.getElementById('showDiv')
  var contents = "<object width=800 height=800 data='/admin/view.matrix.html'>"
  var obj = document.createElement('object')
  obj.data = '/admin/view.matrix.html'
  div.appendChild(obj)
  document.body.appendChild(div)
}


function hopeless() {
  var div = document.querySelector('#showDiv')
  // var html = "<h1> welcome to da matrix </h1>"

  var deev = document.createElement('div')
  var text = document.createTextNode('angelo')
  text.src = "view.matrix.html"
  deev.appendChild(text)
  document.body.appendChild(deev)
  // console.log(text)
  // div.innerHTML = text

  var script = document.createElement('script')
  script.src = "view.matrix.js"
  document.body.appendChild(script)
}


function hope() {
  var body = document.getElementsByTagName('body')[0]
  var div = document.createElement('div')
  var text = document.createTextNode('bob')
  text.src = '/admin/view.matrix.html?studios=bob'
  div.appendChild(text)
  body.appendChild(div)
}

</script>
