<?php
/*****************************************
** File:    error.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file displays the any syntax errors that prevent results.php from executing. 
***********************************************/

	error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include('results.php');	
?>