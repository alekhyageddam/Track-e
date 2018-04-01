<?php
$con = mysqli_connect('database.cs.tamu.edu', 'mattkeith', 'Tracke123','mattkeith') or die (mysql_error());
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
 ['M', 3],
 ['TU', 1],
 ['W', 1],
 ['TH', 1],
 ['F', 3],
 ['SAT', 2],
 ['SUN', 1],
 <?php 
 //$query = "SELECT DISTINCT count(`COUNT`) AS count, `DAY` FROM SampleData GROUP BY `DAY` ORDER BY `DAY`";
 //$exec = mysqli_query($con,$query);
 //while($row = mysqli_fetch_array($exec)){
 //echo "['".$row['`DAY`']."',".$row['count']."],";
 //}
 ?>
 ]);
 var options = { 
    is3D: true,
    title: 'NUMBER OF WALKING INTO REC CENTER THROUGHOUT THE WEEK',
    hAxis: {title: "Days Of The Week"},
    vAxis: {title: "Count of Students"},
   // seriesType: "bars",
   // series: {5: {type: "line"}}
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