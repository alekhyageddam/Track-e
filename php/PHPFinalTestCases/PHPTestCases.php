<?php 
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
#MySQL database will have the known table setup as such (Only some records are show below):
#Count      Time                    Day        Ultrasonic-Value
#1      2018-02-23 10:20:15          M          9
#2      2018-02-24 17:09:48         TU          7
#3      2018-02-24 17:09:56         TU          5
#4      2018-02-25 13:13:09          W          4
#5      2018-02-25 11:50:30          W          3

/*This file uses curl to generate test cases, submit them via POST, and compare them to expected outputs housed in test(#).html files*/

$url = 'htttp://projects.cse.tamu.edu/mattkeith/data.php';

//Below the arrays contain values corresponding to each test

//Test Case 1 - No time span or options inputed
$data1 = array(
	'time-min' = NULL,
	'time-max' = NULL,
	'countCheck' = 'off',
	'peakSelect' = 'none',
);

//Test Case 2 - Only Timespan Entered
$data2 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-02-27T23:00:00',
	'countCheck' = 'off',
	'peakSelect' = 'none',
);

//Test Case 3 - Timespan entered. Count statistics selected.
$data3 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-02-27T23:00:00',
	'countCheck' = 'on',
	'peakSelect' = 'none',
);

//Test Case 4 - Timespan entered. Count statistics selected. Peak calculations set to daily
$data4 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-02-25T23:00:00',
	'countCheck' = 'on',
	'peakSelect' = 'daily',
);

//Test Case 5 - Timespan entered. No count statistics selected. Peak calculations set to daily
$data5 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-02-23T23:00:00',
	'countCheck' = 'off',
	'peakSelect' = 'daily',
);

//Test Case 6 - Timespan entered. Count statistics selected. Peak calculations set to weekly
$data6 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-03-02T08:00:00',
	'countCheck' = 'on',
	'peakSelect' = 'weekly',
);

//Test Case 7 - Timespan entered. No count statistics selected. Peak calculations set to weekly
$data7 = array(
	'time-min' = '2018-02-23T08:00:00',
	'time-max' = '2018-02-24T23:00:00',
	'countCheck' = 'off',
	'peakSelect' = 'weekly',
);

for($i = 1; $i <= 7; $i++) {

$vars = http_build_query(${'data'.(string)$i});

$chan = curl_init();

//Sets POST data and makes $results populate with with returned data
curl_setopt($chan, CURLOPT_URL, $URL);
curl_setopt($chan, CURLOPT_POST, count($data));
curl_setopt($chan, CURLOPT_POSTFIELDS, $postvars);
curl_setopt($chan, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($chan);

$expected = file_get_contents('test'.(string)$i.'.html');

if($result == $expected){
    echo('Test '.(string)$i.' Passed!');
}
else{
    echo('Test '.(string)$i.' Failed');
}
curl_close($chan);

}