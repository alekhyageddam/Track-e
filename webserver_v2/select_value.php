<?php
/*****************************************
** File:    select_value.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file determines whether a user has selected a timeframe(daily,weekly,monthly,yearly).
***********************************************/

if(isset($_POST['submit'])){
    if(!empty($_POST['select'])) {
        $timeFrame = $_POST['select'];
         echo "You have selected " .$timeFrame;
         echo "<br>";
    }
}
?>