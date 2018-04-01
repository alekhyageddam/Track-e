<?php
/*****************************************
** File:    results.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file draws a column graph when the user selects 'Statistics' and 'weekly'.
***********************************************/

//phpMyAdmin credentials
$server = 'database.cs.tamu.edu';
$user = 'xxxxxx';
$pwd = 'xxxxxx';
$db = 'xxxxxx';

//Establish a connection to the MySQL table.
$con = mysqli_connect($server, $user, $pwd,$db) or die (mysql_error());

?>
<!DOCTYPE HTML>
<html>
<head>
 <meta charset="utf-8">
 <title>
 Create Google Charts
 </title>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
    ['DAY', 'COUNT'],
    ['M', 14],
    ['TU', 20],
    ['W', 12],
    ['TH', 7],
    ['F', 28],
    ['SA', 31],
    ['SUN', 30],
 <?php 
 /*
 $query = "SELECT count(ip) AS count, vdate FROM visitors GROUP BY vdate ORDER BY vdate";
 $exec = mysqli_query($con,$query);
 while($row = mysqli_fetch_array($exec)){
 echo "['".$row['vdate']."',".$row['count']."],";
 }
 */
 ?>
 ]);
 var options = {
 title: 'NUMBER OF STUDENTS ENTERING THE REC CENTER THIS WEEK'
 };
 var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
 chart.draw(data, options);
 }
 </script>
</head>
<body>
 <h3>Column Chart</h3>
 <div id="columnchart" style="width: 900px; height: 500px;"></div>
</body>
</html>