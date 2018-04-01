<?php
/*****************************************
** File:    results.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file draws a line graph when the user selects 'Statistics' and 'yearly'.
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable
        ([
          ['Year', 'Count'],
          ['2016',  1000,],
          ['2017',  1170,],
          ['2018',  660,],
        ]);

        var options = 
        {
          title: 'Number of Students Who Entered The Rec Center Over The Years',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>