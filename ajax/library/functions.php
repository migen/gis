<?php
/* loggedin,redirect,pr */

function loggedin(){
	if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
		return true;
	}
	return false;
}

function loginRedirect(){
	if(!loggedin()){ $url = "users/login"; redirect($url); }

}

function pr($arr){
	echo '<pre>'; print_r($arr); echo '</pre>';
}

function redirect($url='index'){
	$u = URL.$url; 
	header("Location: $u");
	exit;
}

