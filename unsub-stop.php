<?php

// stop multiple unsub.php threads

require "process.class.php";

$pids = array_map('trim', array_filter(explode(PHP_EOL, file_get_contents('pids'))));

foreach($pids as $pid) {
    $p = new Process();
    $p->setPid($pid);
    echo "Stopping process with PID=" . $pid . " " . ($p->stop() ? "successful" : "unsuccessful") . PHP_EOL;
}

file_put_contents('pids', '');

