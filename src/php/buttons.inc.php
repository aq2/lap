<?php  // button view and controller

// show buttons for each available table -> need getTables fn
// show red init-db button in nother div

?>

<form method='GET' action='php/buttons_cont.php'>
<div id='ad_buttons'>

    <span id='ad_show'>
    <?php
    //add button for each table
    ?>
    <button>studios</button>
    <button>wkshops</button>
    <button>etc..</button>
    </span>
    <span id='ad_init'>
      <button type='submit' name='initdb'>init database</button>
    </span>
</div>
</form>

<?php
?>
