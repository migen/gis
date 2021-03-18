<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){

case "xeditPaygroup":
	$ecid=$_POST['ecid'];$pgid=$_POST['pgid'];		
	$q="UPDATE {$dbg}.06_paymaster SET paygroup_id='$pgid' WHERE `ecid`  = '$ecid' LIMIT 1;";	
	$_SESSION['q']=$q;				
	$db->query($q);
	break;
	
default:
	break;

	
	
}	/* switch */




	
	