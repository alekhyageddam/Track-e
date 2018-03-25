<?php

	#retrives user input (min, max) time-range from .html file
	$timeMin = $_POST['time-min'];
	$timeMax = $_POST['time-max'];

	$dailyView = $_POST['daily'];
	$weeklyView = $_POST['weekly'];
	$monthlyView = $_POST['monthly'];


	echo $timeMin . " " . $timeMax;	#print out the correct values(for testing purposes)
	#the sql queries will be based on the time spans the user asks for

	$debug = true;
	include ('CommonMethods.php');	//connect to the db
	$COMMON = new Common($debug);	//common methods

	#method to display number of people(count)for a given timeframe
	function getCount()
	{
		global $debug, global $COMMON;
		$sql = "select * from `SampleData` where `Time` between ".$timeMin" and ".$timeMax" order by `count` ASC";
		$rs = $COMMON->executeQuery($sql,$_SEVER["SCRIPT_NAME"]);
		$matches = mysql_num_rows($rs);  //see how many rows are retrieved
		echo("The count is $matches");
		if($matches == 0){
			echo("There were no matches based on the selected timeframe.")
		}
		$rowArray = $rs->fetch(PDO:: FETCH_ASSOC);
		//collects row data into an array called rowArray
		return $rowArray['']
	}

	#method to generate the avg number of students for given timeframe
	function getAverage()
	{
		global $debug, global $COMMON;
		//get a count of the distinct number of days
		$sql = "select count (distinct day) from `SampleData` where `Time` between $timeMin and $time";
		$rs = $COMMON->executeQuery($sql,$_SEVER["SCRIPT_NAME"]);
		$distinctDays = mysql_num_rows($rs); 
		//get a count of the records retrieved for the selected timeframe
		$pplCount = getCount();
		$avgNum = $pplCount / $distinctDays;
		echo ("The average number of students for the selected timeframe is " .$avgNum);
	}

	#method to graph points for visual representation
	#method to generate highest and lowest points in day/week/month
	#statistical method to analyze data (median, mode etc) for a given timeframe
?>