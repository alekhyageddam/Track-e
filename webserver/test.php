<?php
// Create connection
$con = mysqli_connect('database.cs.tamu.edu', 'mattkeith', 'Tracke123','mattkeith') or die (mysql_error());
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully<br>";

//set time-zone for calculations
date_default_timezone_set('america/chicago');

//include other relevant php files
include('select_value.php');
include('radio_value.php');

$start = $_POST['time-min'];
$end = $_POST['time-max'];

#retrives user input (min, max) time-range
$timeMin = date('Y-m-d H:i:s', strtotime($_POST['time-min']));
$timeMax= date('Y-m-d H:i:s', strtotime($_POST['time-max']));

$date1 = new DateTime(date('d-M-Y', strtotime($_POST['time-min'])));
$date2 = new DateTime(date('d-M-Y', strtotime($_POST['time-max'])));
$interval = date_diff($date1,$date2);
$numMonths = $interval->m + (($interval->y * 12)+1) . ' months <br>';


$start = date('Y-M-D',$_POST['time-min']);
$end = date('Y-M-D',$_POST['time-max']);
$getRangeYear   = range(gmdate('Y', strtotime($start)), gmdate('Y', strtotime($end)));
$numYears = count($getRangeYear);
//echo $numYears . ' year(s)';
//print_r($getRangeYear);
echo "<br>";


$diff = date_diff($date1,$date2);
//echo 'Days Count: '.$diff->format("%a") ,'<br>';

//echo 'Years count: '.$diff->format("%y"), '<br';

//echo "The time range selected is :  ";
//echo $timeMin . "  to  " . $timeMax ."<br> <br>";

//print out the difference in various time intervals
//function to print results
function printResults($result){
	echo "<table><tr>";
	//print the column headers
	for($i = 0; $i < mysqli_num_fields($result); $i++) {
		$field_info = mysqli_fetch_field($result, $i);
		echo "<th>{$field_info->name}</th>";
	}
	//print the data
	while($row = mysqli_fetch_row($result)) {
		echo "<tr>";
		foreach($row as $_column) {
			echo "<td>{$_column}</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

function getCount(){
		//echo "<pre>Debug: $query</pre>\m";
		global $timeMin, $timeMax;
		$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
		$result = mysqli_query($con, $query);
		//echo "<pre>Debug:$query</pre>\m";
		$matches = mysqli_num_rows($result);
		echo("The count for the selected time range is $matches");
		printResults($result);	
}
switch ($_POST['radio']) {
	// if count => calculate count
	case 'count':
		$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
		//echo "<pre>Debug: $query</pre>\m";
		$result = mysqli_query($con, $query);
		$matches = mysqli_num_rows($result);
		echo("The count for the selected time range is $matches");
		printResults($result);	//print results here *
	break;
	// if average selected => calculate average for the specified time frame
	case 'avg':
			switch($_POST['select']){
				//if daily
				case 'daily':
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
					//echo "<pre>Debug: $query</pre>\m";
					$result = mysqli_query($con, $query);
					$matches = mysqli_num_rows($result);
					echo("The count for the selected time range is $matches");
					printResults($result);	//print results here */

					$hoursInADay = 8; //consider business hours
					$avgDaily = $matches / $hoursInADay;
					echo "The average number of people in a day (assuming office hours 8-5 p.m.) is " .$avgDaily;
					//calcAvg($timeFrame);
				break;
				
				//if weekly
				case 'weekly':
					$query = "SELECT DISTINCT(`DAY`) FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax' ORDER BY `TIME` ASC";
					$result = mysqli_query($con, $query);
					$numDays = mysqli_num_rows($result);
				//	echo("<br> The num of days is $numDays <br> ");
					$daysInW = $numDays + 1;

					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
					//echo "<pre>Debug: $query</pre>\m";
					$result = mysqli_query($con, $query);
					$pplInW = mysqli_num_rows($result);
				//	echo("The number of students in the time interval is $pplInW <br>");
					printResults($result);	//print results here */

					$avgWeekly = $pplInW / $daysInW;
					echo("<br> The average number of people in a week is $avgWeekly");
				break; 	//for weekly

				//if monthly
				case 'monthly':
					echo $numMonths;
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
					//echo "<pre>Debug: $query</pre>\m";
					$result = mysqli_query($con, $query);
					$pplInM = mysqli_num_rows($result);
					echo("The number of students in the time interval is $pplInM <br> <br>");
					printResults($result);	//print results here */
					$avgMonths = $pplInM/$numMonths;
					echo ("The average number of people in a month is $avgMonths");
				break;

				case 'yearly':
					echo $numYears;
					//count number of people in a year
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
					//echo "<pre>Debug: $query</pre>\m";
					$result = mysqli_query($con, $query);
					$pplInY = mysqli_num_rows($result);
					echo("The number of students in the time interval is $pplInY <br> <br>");
					printResults($result);
					$avgYears = $pplInY/$numYears;
					echo ("The average number of people in a year is $avgYears");
				break;
			} //end switch statement for avg
	
	//plot statistics for given timeframe	
	case 'graph': 	
			switch($_POST['select']){
				case 'weekly': //column chart
					include ('column.php');	
				break;
				case 'monthly': //column chart
					include ('pie.php');	
				break;
				case 'yearly': //pie chart
					include ('line.php');	
				break;					
			}
}
// mysqli_close($con);	
?>