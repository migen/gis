<?php

// echo "hello abs fxn here ";

function sesstimeout($min=30){
	// echo "abs fxn sess timeout here ";
	$expireAfter = $min;	 
	if(isset($_SESSION['last_action'])){		
		$secondsInactive = time() - $_SESSION['last_action'];		
		$expireAfterSeconds = $expireAfter * 60;		
		if($secondsInactive >= $expireAfterSeconds){
			session_unset();
			session_destroy();
		}		
	}	 
	$_SESSION['last_action'] = time();	
	
}	/* fxn */
