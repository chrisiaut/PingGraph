<?php

function pingTarget($target,$timeout=2000)
{
	$start = microtime(true);
	$cmd = 'ping -w '.$timeout.' -n 1 '.$target;
	$filename = 'data_'.$target.'.txt';

	$return = shell_exec($cmd);

	$arr = explode("\n", $return);
	$arr = explode(' ', trim($arr[2]));

	$newfile = file_exists($filename)?false:true;

	$fp = fopen($filename, 'a');

	if($arr[0]!='Antwort' && trim($arr[2])!= 'Anforderung.')
		echo "[X] Error1!\n".print_r($arr,true)."\n";
	else
	{
		$rt = 0;
		if($arr[3]=='Zielhost' || trim($arr[2])=='Anforderung.')
			$rt = $timeout;
		else if($arr[4]=='Zeit<1ms')
			$rt = 1;
		else
		{
			$a=explode('=', $arr[4]);
			$rt = $a[1];
		}
		if($rt)
		{
			if(substr($rt,-2)=='ms')
				$rt = substr($rt, 0, -2);
			if($GLOBALS['last']!=$rt || $rt==$timeout)
			{
				echo "[+] Target answered in $rt ms\n";
				if(!$newfile)
					fwrite($fp, ',');
				fwrite($fp, '['.(time()*1000).','.$rt.']');
			}
			else
			{
				echo '.';
			}
			$GLOBALS['last'] = $rt;
			

		}
		else
			echo "[X] Error2!\n".print_r($arr,true)."\n";
	}

	fclose($fp);

	return microtime(true)-$start;
}