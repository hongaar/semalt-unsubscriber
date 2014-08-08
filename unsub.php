<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require "vendor/autoload.php";

$curl = new Curl;

// THIS MIGHT NEED SOME TESTING BEFORE YOU START
$currentServer = 13;

$fetchTargetUrl = "http://server" . $currentServer . ".openfrost.com/get_link.php?newagent=1";

while(1) {
	$response = (object) [ 'body' => '' ];
	try {
		$response = $curl->get($fetchTargetUrl);
	} catch(Exception $e) {
		echo 'url could not load ' . $fetchTargetUrl;
		continue;
	}

	$target = explode('=', $response->body);
	if (!isset($target[1]) || empty($target[1])) {
		continue;
	}
	$target = $target[1];
	$unsubscribeUrl = "http://semalt.com/handlers/crawler.php";

	$response = (object) [ 'body' => '' ];
	try {
		$curl->post($unsubscribeUrl, array('domains' => $target));
	} catch(Exception $e) {
		echo 'url could not load ' . $unsubscribeUrl;
		continue;
	}

	file_put_contents('unsubscribed.log', $target . PHP_EOL, FILE_APPEND);
	echo "Unsubscribed " . $target . PHP_EOL;
}