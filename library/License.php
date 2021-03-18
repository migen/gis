<?php


function matchKeys($localkey){
	$url 		= "http://aizent.com/go/gispass.php";
	$svrkey 	= file_get_contents($url);
	echo "svrkey: $svrkey <br />";
	return ($localkey==$svrkey)? true:false;

}	/* fxn */

function checkLicense($validity,$localkey){
	$today = date('Y-m-d');
	echo "today: $today <br />";
	echo "validity: $validity <br />";
	echo ($today<$validity)? 'valid':'renew';
	echo '<br />';
		
	$is_valid = ($today<$validity)? true:false;
		
	if(!$is_valid){
		echo "expired, check vaility matchkeys <br />";
		$keys_matched = matchKeys($localkey);
		if($keys_matched){
			echo "keys matched, continue <br />";
		} else {
			echo "keys DONT match, exit <br />";
			exit;
		}
	} else {
		echo "still not expired";
	}
	
		
}


$validity='2015-12-23';
$localkey="makolpass";

checkLicense($validity,$localkey);


