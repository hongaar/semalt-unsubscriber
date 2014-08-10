<?php

$countEverySecond = 1;
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

function getlinecount()
{
	clearstatcache();
	$file = "unsubscribed.md5.log";
	return (int) (filesize($file) / 33);
}