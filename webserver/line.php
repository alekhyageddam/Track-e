<?php
$con = mysqli_connect('database.cs.tamu.edu', 'mattkeith', 'Tracke123','mattkeith') or die (mysql_error());
?>
<!DOCTYPE HTML>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales'],
          ['2016',  1000,],
          ['2017',  1170,],
          ['2018',  660,],
        ]);

        var options = {
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