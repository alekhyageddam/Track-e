<?php
/*****************************************
** File:    results.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** This file draws a pie chart when the user selects 'Statistics' and 'monthly'.
***********************************************/
$server = 'database.cs.tamu.edu';
$user = 'xxxxxx';
$pwd = 'xxxxxx';
$db = 'xxxxxx';

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
    var data = google.visualization.arrayToDataTable
    ([
         ['MONTH', 'COUNT'],
         ['January', 45],
         ['February', 47],
         ['March', 31],
         ['April', 67],
         ['May', 29],
         ['June', 33],
         ['July', 37],
         ['August', 49],
         ['September', 70],
         ['October', 81],
         ['November', 58],
         ['December', 45],  
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

    var options = 
     {
        title: '  NUMBER OF STUDENTS IN YEAR: 2018  ',
        pieHole: 0.4,
    };

    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);

//end function here  
 }
</script>
</head>
    <body>
        <div id="donutchart" style="width: 900px; height: 500px;"></div>
    </body>
</html>

