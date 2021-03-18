<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbg = PDBG;

switch($_POST['task']){


case "xdelPayment":
	$payid=$_POST['payid'];
	$vsy=$_POST['vsy'];
	$ptable=$_POST['ptable'];
	$dbg=VCPREFIX.$vsy.US.DBG;		
	$q = " DELETE FROM {$dbg}.`$ptable` WHERE `id`='$payid' LIMIT 1; ";	 
	$_SESSION['q'] = $q;
	$db->query($q);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
