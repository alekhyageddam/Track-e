<?php

function print_graphPie($timeMin, $timeMax, $con, $select){
	echo "<script type=\"text/javascript\">
	     google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
        var dataPie = google.visualization.arrayToDataTable([
          [{type: 'string', label: 'Date'}, {type: 'number', label: 'Count'}],";

$query = "SELECT `TIME` FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'";

$result = mysqli_query($con, $query);
if($result == false)
	echo 'Connection Failed';

$Ma = "-1";
$ccount = 0;
switch($select){
	
case("monthly"):
while($row = mysqli_fetch_row($result)) {
	
			$Y = substr($row[0],0,4);
			$M = substr($row[0],5,2);
			$D = substr($row[0],8,2);
					
			$MY = $M . "-" . $Y;
			if($Ma == "-1" || $MY != $Ma)
			{
				
				if($Ma != "-1"){
					echo "['{$Ma}', {$ccount}], ";
					$ccount = 0;
				}
					$Ma = $MY;
					$ccount = $ccount + 1;
			}
			else
			{$ccount = $ccount + 1;}
}
echo "['{$Ma}', {$ccount}], ";
break;

case("daily"):
$iDMY = "";
while($row = mysqli_fetch_row($result)) {
	
			$Y = substr($row[0],0,4);
			$M = substr($row[0],5,2);
			$D = substr($row[0],8,2);
					
			$DMY = $D . "-" . $M . "-" . $Y;
			if($iDMY == "" || $DMY != $iDMY)
			{
				if($iDMY != NULL){
					echo "['{$iDMY}', {$ccount}], ";
					$ccount = 0;
				}
					$iDMY = $DMY;
					$ccount = $ccount + 1;
			}
			else
			{$ccount = $ccount + 1;}
}
echo "['{$iDMY}', {$ccount}], ";
break;

case("yearly"):
$iY = "-1";
$ccount = 0;
while($row = mysqli_fetch_row($result)) {
	
			$Y = substr($row[0],0,4);
			
			if($Y == "-1" || $Y != $iY)
			{
				if($iY != "-1"){
					echo "['{$iY}', {$ccount}], ";
					$ccount = 0;
				}
					$iY = $Y;
					$ccount = $ccount + 1;
			}
			else
			{$ccount = $ccount + 1;}
}
echo "['{$iY}', {$ccount}], ";
break;
}

echo"
       ]);
      
        var optionsPie = {
          title: 'Count ({$select})'
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('chart_div_Pie'));
        chart.draw(dataPie, optionsPie);
      }
	  </script>";}

function print_graph($timeMin, $timeMax, $con){
	echo '
	    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
  //  <div id="chart_div2"></div> 
     google.charts.load(\'current\', {\'packages\':[\'corechart\']});
     google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [{type: \'date\', label: \'Date\'}, {type: \'timeofday\', label: \'Time of Day\'}],
		  ';

$query2 = "SELECT `TIME` FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'";
$result = mysqli_query($con, $query2);

if($result == false)
	echo 'Connection Failed';


while($row = mysqli_fetch_row($result)) {
	
			$Y = substr($row[0],0,4);
			$M = substr($row[0],5,2);
			$D = substr($row[0],8,2);
			
			$H = substr($row[0],11,2);
			$m = substr($row[0],14,2);
			$S = substr($row[0],17,2);
	echo "[new Date({$Y}, {$M}, {$D}), [{$H}, {$m}, {$S}]], ";}
	

		  
echo '		  
       ]);
      
        var options = {
          title: \'Date-Time Graph\',
          hAxis: {title: \'Date\'},
          vAxis: {title: \'Time Of Day\',
					maxValue: [23, 59,59,],
					minValue: [0,0,0]},
        
        };
      
        var chart = new google.visualization.ScatterChart(document.getElementById(\'chart_div\'));
        chart.draw(data, options);
      }
	  </script>';}

function print_header(){
	
echo '
<!DOCTYPE HTML>
<html lang="en">
<head>';}

function print_options(){
	
echo '											
</head>
<body>

<h2>Results</h2>

											<div id="chart_div" style="width:900px; height:500px"></div>
											
											<div id="chart_div_Pie" style="width:900px; height:500px"></div>
											
											<fieldset>
                                            <h2>Options</h2>
                                            <form action="results.php" method="POST">
                                            Timespan: <input type="datetime-local" name="time-min" required></input> to <input type="datetime-local" name="time-max" required></input>
                                            <br> <br>
                                            
                                            Select a measure to view: <br>
                                            <!-- Select Radio Buttons Starts Here --> 
                                            <input type="radio" name="radio" value="count"> Count<br> 
                                            <input type="radio" name="radio" value="avg"> Average<br> 
                                            <input type="radio" name="radio" value="graph"> Statistics<br> 
                                            
                                            <!-- Select Button Starts Here -->
                                            <br> 
                                            Calculate results with a 
                                            <select id = "select" name="select">
                                            <option value="daily">daily</option>
                                            <option value="weekly">weekly</option>
                                            <option value="monthly">monthly</option>
                                            <option value="yearly">yearly</option>
                                            </select>
                                            unit time frame                        
                                            <br> <br>
                                            <input type="submit" name="submit" value="Submit" />
                                            </fieldset>
                                            </form>
                                      
            </body>
</html>';}





?>