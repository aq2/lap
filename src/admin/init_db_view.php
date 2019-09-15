<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
</head>

<body>

<?php
  require_once('admin_buttons.php');
?>

<h1>warning</h1>
<p>this will wipe the current database</p>
<button id='initBtn'> initialize database </button>

<div id='output'> </div>


<script src='/js/functions.js'></script>
<script>
  // enable $ selector
  bling()

  $('#initBtn').on('click', loadPHP)

  // load php into #output div
  function loadPHP() {
    loadDoc('init_db.php', 'output')
  }
</script>
</body>
