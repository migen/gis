<?php


function isMIS(){
	$user=$_SESSION['user'];
	return ($user['role_id']==RMIS)? true:false;

}	/* fxn */


