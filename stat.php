<?php

$countEverySecond = 5;
$statEverySecond = 60;

$start = microtime(true);
$lines = getlinecount();

$startAverage = $start;
$linesAverage = $lines;

$i = 0;
while(1) {
	sleep($countEverySecond);
	$i++;

	if ($i > ($statEverySecond / $countEverySecond)) {
		$passed = microtime(true) - $startAverage; 
		echo date('c') . ": averaging " . ((getlinecount() - $linesAverage) / $passed) . " urls/s" . str_repeat(" ", 40) . PHP_EOL;

		$startAverage = microtime(true);
		$linesAverage = getlinecount();
		$i = 0;
	}

	$passed = microtime(true) - $start; 
	echo "Processed " . ((getlinecount() - $lines) / $passed) . " urls/s" . str_repeat(" ", 40) . "\r";

	$start = microtime(true);
	$lines = getlinecount();
}


// http://stackoverflow.com/a/2162528/938297
function getlinecount()
{
	$file = "unsubscribed.log";
	$linecount = 0;
	$handle = fopen($file, "r");
	while(!feof($handle)) {
		$line = fgets($handle);
		$linecount++;
	}
	fclose($handle);
	return $linecount;
}