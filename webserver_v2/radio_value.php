<?php
/*****************************************
** File:    select_value.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file determines whether a user has selected any of the measures on the form.
***********************************************/

if (isset($_POST['submit'])) {
    if(isset($_POST['radio']))
    {
        $statCalc = $_POST['radio'];
       echo "<span>You have selected :<b> ".$statCalc."</b></span>";
        echo "<br>";
    }
    else
    { 
        echo "<span>Please choose a measure to view.</span>";}
    }
?>