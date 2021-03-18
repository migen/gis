<?php

class Mi extends Model{


public function __construct(){
	parent::__construct();
}



public function sessionizeMIS($dbg){
	$dbo=PDBO;		
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_mis.php");
	require_once(SITE."functions/sessionize_lis.php");
	require_once(SITE."functions/sessionize_invis.php");
	require_once(SITE."functions/sessionize_account.php");
	$db	=&	$this->db;

	$ucid = $_SESSION['user']['ucid'];	
	/* 2 - settings */	
	sessionizeSettingsGis($db,$dbg);	
	$this->urooms($ucid);	
	sessionizeTablesMIS($db,$dbg);
	if($_SESSION['settings']['has_axis']){ sessionizeAccount($db); }		
	sessionizeUserByUcid($db,$ucid);	
	sessionizeTime();
	if($_SESSION['settings']['has_axis']){ sessionizeLis($db); }	
	
	
	/* 3 - etc */
	unset($_SESSION['crid']);
	unset($_SESSION['erid']);
	
}	/* fxn */
 

 
public function reset(){
	echo "MI Model reset fxn";
} 
 


} 	/* Mi Model */

