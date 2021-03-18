<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;
$dbo=PDBO;


switch($_POST['task']){

case "xeditSettings":
	$sgid=$_POST['sgid'];
	$sy=$_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$name=$_POST['name'];
	$label=$_POST['label'];
	$value=$_POST['value'];	
	$q = " UPDATE {$dbo}.`00_settings` SET 
				`label` = '".$label."', 
				`value` = '".$value."' 
			WHERE `id` = '".$sgid."' LIMIT 1; ";
	$db->query($q);
	if($sy==DBYR){ 
		$_SESSION['settings'][$name]=$value; 
		if($name=='quarter'){ $_SESSION['qtr']=$value; }
		if($name=='school_year'){ $_SESSION['sy']=$value; }	
	}
	break;
	
	
	
default:
	break;

	
	

}	/* switch */




	

	
