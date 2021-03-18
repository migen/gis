<?php

class Session{

public static function init(){
	$secure = false; /* True IF https. */
	$httponly = true;
	session_start();
}

public static function set($key,$value){ $_SESSION[$key] = $value; }
public static function message($message){ return Session::set('message',$message); }


public static function get($key){
	if(isset($_SESSION[$key])){ return $_SESSION[$key]; }
}

public static function logout(){
	$rurl=isset($_SESSION['rurl'])? $_SESSION['rurl']:NULL;
	if(isset($_SESSION)){
		unset($_SESSION);session_destroy();	
		$_SESSION['rurl']=$rurl;
	}
}
 

} 	/* Session */