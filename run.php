#!/usr/bin/php
<?php

// tick use required as of PHP 4.3.0
declare(ticks = 1);

// signal handler function
pcntl_signal(SIGINT, "sig_handler");
function sig_handler($signo)
{
	$colors = new Colors();
	echo "\r";
	echo $colors->getColoredString("Received SIGINT, now stopping", null, 'red') . PHP_EOL;
	passthru('php ./unsub-stop.php');
	exit;
}

// override with `php run.php 50`
$numThreads = '';
if (isset($argv[1]) && is_numeric($argv[1])) {
	$numThreads = $argv[1];
}

require 'colors.class.php';
$colors = new Colors();

echo $colors->getColoredString("Installing from composer", 'black', 'cyan') . PHP_EOL;
passthru('composer install');
echo $colors->getColoredString("Starting unsub threads", 'black', 'cyan') . PHP_EOL;
passthru('php ./unsub-start.php ' . $numThreads);
echo $colors->getColoredString("Now running, stop with CTRL-C", 'black', 'cyan') . PHP_EOL;
passthru('php ./stat.php');