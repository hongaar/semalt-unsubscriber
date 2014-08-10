#!/usr/bin/php
<?php

// tick use required as of PHP 4.3.0
declare(ticks = 1);

pcntl_signal(SIGINT, "sig_handler");

// signal handler function
function sig_handler($signo)
{
	$colors = new Colors();
	echo "\r";
	echo $colors->getColoredString("Received SIGINT, now stopping", null, 'red') . PHP_EOL;
	passthru('php ./unsub-stop.php');
	exit;
}

require 'colors.class.php';

$colors = new Colors();

echo $colors->getColoredString("Installing from composer", 'black', 'cyan') . PHP_EOL;
passthru('composer install');
echo $colors->getColoredString("Starting unsub threads", 'black', 'cyan') . PHP_EOL;
passthru('php ./unsub-start.php');
echo $colors->getColoredString("Now running, stop with CTRL-C", 'black', 'cyan') . PHP_EOL;
passthru('php ./stat.php');