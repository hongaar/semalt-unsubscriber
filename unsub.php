<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require "vendor/autoload.php";

$curl = new Curl;

// THIS MIGHT CHANGE OVER TIME, TEST BEFORE YOU START
$currentServer = 13;

$fetchTargetUrl = "http://server" . $currentServer . ".openfrost.com/get_link.php?newagent=1";

while(1) {
	$response = (object) [ 'body' => '' ];
	try {
		$response = $curl->get($fetchTargetUrl);
	} catch(Exception $e) {
		echo 'url could not load ' . $fetchTargetUrl;
		file_put_contents('errors.log', 'error fetching ' . $fetchTargetUrl . PHP_EOL, FILE_APPEND);
		continue;
	}

	$target = explode('=', $response->body);
	if (!isset($target[1]) || empty($target[1])) {
		file_put_contents('errors.log', 'invalid response body (' . serialize($target) . ")" . PHP_EOL, FILE_APPEND);
		continue;
	}
	$target = $target[1];
	$unsubscribeUrl = "http://semalt.com/handlers/crawler.php";

	$response = (object) [ 'body' => '' ];
	try {
		$curl->post($unsubscribeUrl, array('domains' => $target));
	} catch(Exception $e) {
		echo 'url could not load ' . $unsubscribeUrl;
		file_put_contents('errors.log', 'error fetching ' . $unsubscribeUrl . PHP_EOL, FILE_APPEND);
		continue;
	}

	file_put_contents('unsubscribed.log', $target . PHP_EOL, FILE_APPEND);
	echo "Unsubscribed " . $target . PHP_EOL;
}