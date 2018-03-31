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
/*
 $query = "SELECT DISTINCT count(`COUNT`) AS count, `DAY` FROM SampleData GROUP BY `DAY`";
 $exec = mysqli_query($con,$query);
 while($row = mysqli_fetch_array($exec)){
 echo "['".$row['`TIME`']."',".$row['count']."],";
 }
 */
 ?>
 ]);

 var options = {
    title: 'NUMBER OF STUDENTS IN A WEEK',
    pieHole: 0.4,
 };

 var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

 chart.draw(data, options);
 }
 </script>
</head>
<body>
<!-- <h3>NUMBER OF STUDENTS IN A WEEK</h3> -->
 <div id="donutchart" style="width: 900px; height: 500px;"></div>
</body>
</html>

