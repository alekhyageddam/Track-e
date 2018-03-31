<?php
if (isset($_POST['submit'])) {
    if(isset($_POST['radio']))
    {
        $statCalc = $_POST['radio'];
       echo "<span>You have selected :<b> ".$statCalc."</b></span>";
        echo "<br>";
    }
    else
    { 
        echo "<span>Please choose any radio button.</span>";}
    }
?>