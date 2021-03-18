<?php

function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];	

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    } elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    } else {
        $ip = $remote;
    }
	$_SESSION['ip']=$ip;
    return $ip;
}


function getSubdept($db){
	$ip=getUserIP();$dbo=PDBO; 
	$q="SELECT * FROM {$dbo}.88_ip_subdepts WHERE ip='$ip' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	
}	/* fxn */
