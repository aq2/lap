<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet', href='/main.min.css'>
  <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
</head>

<body>

<?php
  require_once('admin_buttons.php');
?>

<h1>warning</h1>
<p>this will wipe the current database</p>
<button id='init'> initialize database </button>

<div id='output'> </div>


<script>
  $('#init').click(()=> {
    $('#output').load('init_db.php')
  })
</script>
