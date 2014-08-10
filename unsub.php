<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require "vendor/autoload.php";

$curl = new Curl;

// THIS MIGHT CHANGE OVER TIME, TEST BEFORE YOU START
$currentServer = 13;

$fetchTargetUrl = "http://server" . $currentServer . ".openfrost.com/get_link.php?newagent=1";
echo "using server " . $fetchTargetUrl . PHP_EOL;

while(1) {
	$response = (object) [ 'body' => '' ];
	try {
		echo "retreiving new site to block" . PHP_EOL;
		$response = $curl->get($fetchTargetUrl);
	} catch(Exception $e) {
		echo 'ERROR url could not load ' . $fetchTargetUrl;
		file_put_contents('errors.log', 'error fetching ' . $fetchTargetUrl . PHP_EOL, FILE_APPEND);
		continue;
	}

	echo "got response body: " . $response->body . PHP_EOL;
	$target = explode('=', $response->body);
	if (!isset($target[1]) || empty($target[1])) {
		echo "ERROR response body didn't contain the '=' sign to split the string" . PHP_EOL;
		file_put_contents('errors.log', 'invalid response body' . PHP_EOL, FILE_APPEND);
		continue;
	}
	
	$target = $target[1];
	$unsubscribeUrl = "http://semalt.com/handlers/crawler.php";

	$response = (object) [ 'body' => '' ];
	try {
		echo "submit site for blocking" . PHP_EOL;
		$curl->post($unsubscribeUrl, array('domains' => $target));
	} catch(Exception $e) {
		echo 'ERROR url could not load ' . $unsubscribeUrl;
		file_put_contents('errors.log', 'error fetching ' . $unsubscribeUrl . PHP_EOL, FILE_APPEND);
		continue;
	}

	echo "unsubscribed " . md5($target) . PHP_EOL;
	file_put_contents('unsubscribed.log', md5($target) . PHP_EOL, FILE_APPEND);
}