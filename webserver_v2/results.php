<?php
/*****************************************
** File:    results.php
** Project: CSCE 315 Project 1, Spring 2018
** Author:  XXXXX
** Date:    3/31/18
** Section: 315-501
** E-mail:  xxx@tamu.edu 
** The form.html file redirects to this file when the user clicks the submit button.
***********************************************/

//Establish a connection to the database
$server = 'SERVER_ADDRESS;
$user = 'USERNAME';
$pwd = 'PASSWORD';
$db = 'DATABASE';
$con = mysqli_connect($server, $user, $pwd,$db) or die (mysql_error());

//verify connection is established
if (!$con) 
{
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully<br>";

//set time-zone for calculations
date_default_timezone_set('america/chicago');	

//include other relevant php files
include('select_value.php');
include('radio_value.php');
include ('options.php');

$timeMin = date('Y-m-d H:i:s', strtotime($_POST["time-min"]));	//store minimum value of user-entered time range
$timeMax= date('Y-m-d H:i:s', strtotime($_POST["time-max"]));  	//store maximum value of user-entered 
$select = $_POST['select'];


$date1 = new DateTime(date('d-M-Y', strtotime($_POST["time-min"])));	//retrieve only date part of timeMin
$date2 = new DateTime(date('d-M-Y', strtotime($_POST["time-max"])));	//retrieve only date part of timeMax
$interval = date_diff($date1,$date2);									//find the interval between $date1 and $date2
$numMonths = $interval->m + (($interval->y * 12)+1) . ' months <br>';   //calculate the number of months between two dates and store in $numMonths

$start = date('Y-M-D',$_POST['time-min']);											  //retrieve only date part of timeMin										
$end = date('Y-M-D',$_POST['time-max']);											  //retrieve only date part of timeMax
$getRangeYear = range(gmdate('Y', strtotime($start)), gmdate('Y', strtotime($end)));  //calculate the range of years between two dates
$numYears = count($getRangeYear);													  //number of years between two given dates 
echo "<br>";



print_header();
print_graph($timeMin, $timeMax, $con);

//print out the data that corresponds to the result of a query
function PrintResults($result){}
	
	
	
	

//Now, below is a switch case embedded within a bigger switch case statement.
switch ($_POST['radio']) {

	// if user selects count => calculate count for the selected time range
	case 'count':
		//get all the records between the user-defined time range
		$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 

		//execute the query above
		$result = mysqli_query($con, $query);	

		//count the number of records that match the query		
		$matches = mysqli_num_rows($result);

		//print the count of students
		echo("The number of people in the selected timeframe is $matches");

		//print the corresponding data from MySQL table
		PrintResults($result);	//print results here *
	break;

	// if the user selects 'average', calculate the average for the selected time range. 
	case 'avg':
			switch($_POST['select']){
				//if 'Average' and 'daily' selected
				case 'daily':
					//get all the records between the user-defined time range
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 

					//execute the query above
					$result = mysqli_query($con, $query);

					//count the number of records that match the query
					$matches = mysqli_num_rows($result);

					//print the count of students
					echo("The count for the selected time range is $matches");

					//print the corresponding data from MySQL table
					PrintResults($result);	//print results here */

					//number of business hours in a day 
					$hoursInADay = 8; 

					//calculate average number of students on a given day
					$avgDaily = $matches / $hoursInADay;

					//print the result
					echo "<br>The average number of people in a day (assuming office hours 8-5 p.m.) is " .$avgDaily;
				
				//break for daily
				break;	
				
				//if 'Average' and 'weekly' selected
				case 'weekly':
					//get the days of all records between the user-defined time range
					$query = "SELECT DISTINCT(`DAY`) FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax' ORDER BY `TIME` ASC";

					//execute the query above
					$result = mysqli_query($con, $query);

					//count the number of days that match the query
					$numDays = mysqli_num_rows($result);

					//determine the days in the week
					$daysInW = $numDays + 1;

					//get all the records between the user-defined time range
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 
					
					//execute the query above
					$result = mysqli_query($con, $query);

					//determine the number of people in a week
					$pplInW = mysqli_num_rows($result);

					//print the data corresponding to the week's timeframe
					PrintResults($result);

					//calculate the average number of people in a week
					$avgWeekly = $pplInW / $daysInW;

					//print the result for average ppl in a week
					echo("<br> The average number of people in a week is $avgWeekly");
				//end case weekly
				break; 	

				//if 'Average' and 'monthly' selected
				case 'monthly':
					//get all the records between the user-defined time range
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '$timeMin' AND '$timeMax'"; 

					//execute the query above
					$result = mysqli_query($con, $query);

					//determine the number of people in a month
					$pplInM = mysqli_num_rows($result);

					//print the number of students in the selected month
					echo("The number of students in the month is $pplInM <br> <br>");

					//print the data corresponding to the months's timeframe
					PrintResults($result);	

					//calculate the average people per month
					$avgMonths = $pplInM/$numMonths;

					echo ("The average number of people in a month is $avgMonths");
				break; //end case monthly

				case 'yearly':
					//count number of people in a year
					echo $numYears;
					
					//get all the records between the user-defined time range
					$query = "SELECT * FROM SampleData WHERE `TIME` BETWEEN '{$timeMin}' AND '{$timeMax}'"; 

					//execute the query above
					$result = mysqli_query($con, $query);

					//determine the number of people in a year
					$pplInY = mysqli_num_rows($result);

					//print the number of students in the selected year
					echo("The number of students in the time interval is $pplInY <br> <br>");

					//print the data corresponding to the year(s) timeframe
					PrintResults($result);

					//calculate the average people per year
					$avgYears = $pplInY/$numYears;

					//print the result
					echo ("The average number of people in a year is $avgYears");
				//end case for 'yearly'
				break;	
			} 
	//end case for avg here
	break;	

	//plot graphs for given timeframe	
	case 'graph': 	
			print_graphPie($timeMin, $timeMax, $con, $select);
			break;
//end original switch statement here			
}

print_options();

//close connection here
 mysqli_close($con);	

?>
