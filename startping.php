<?php

include('pinger_win.php');
$timeout = 500; //in ms
$sleeptime = 1; //in seconds


while(1)
{
	$duration = pingTarget('192.168.1.115',$timeout);

	$dif = $sleeptime-$duration;

	if($dif>0)
		usleep($dif*1000000);
}