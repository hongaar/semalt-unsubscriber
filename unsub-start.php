<?php

// start multiple unsub.php threads

require "process.class.php";

$numThreads = 10;

// override with `php ./unsub-start.php 50`
if (isset($argv[1]) && is_numeric($argv[1])) {
	$numThreads = $argv[1];
}

echo "Starting " . $numThreads . " threads..." . PHP_EOL;

while ($numThreads--) {
	$p = new Process('php ./unsub.php');
	echo "Opening new thread with PID=" . $p->getPid() . PHP_EOL;
	file_put_contents('pids', $p->getPid() . PHP_EOL, FILE_APPEND);
}

