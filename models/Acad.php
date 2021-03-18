<?php

class Acad extends Model{



public function __construct(){
	parent::__construct();
}



function keygen($len=6){
	$alpha   = str_shuffle('qwertyupasdfghjkzxcvbnm');
	$alpha1  = substr(str_shuffle('qwertyupasdfghjkzxcvbnm'),5,2);
	$alpha2  = substr(str_shuffle('qwertyupasdfghjkzxcvbnm'),5,2);
	$nums    = substr(str_shuffle('23456789'),5,2);
	$pass 	 = $alpha1.$nums.$alpha2;

	if(($len >= 7) && ($len <= 12)){
		$charsLeft = $len - 6;		
		$alpha3  = substr($alpha,0,$charsLeft);
		$pass .= $alpha3;
	}	
	return $pass;	
}



 
public function sessionizeAcad($dbg=PDBG){	/* RACAD=4 */
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->db;
	$ucid = $_SESSION['user']['ucid'];
	sessionizeUserByUcid($db,$ucid);		
	$this->urooms($ucid);

}	/* fxn */






} /* Acad */



