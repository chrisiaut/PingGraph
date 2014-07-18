<?php

//php startping.php <target> <timeout in ms> <sleeptime in s>

$target = $argv[1]?$argv[1]:'192.168.1.115';

include('pinger_win.php');
$timeout = $argv[2]?$argv[2]:500; //in ms
$sleeptime = $argv[3]?$argv[3]:1; //in seconds


while(1)
{
	$duration = pingTarget($target,$timeout);

	$dif = $sleeptime-$duration;

	if($dif>0)
		usleep($dif*1000000);
}