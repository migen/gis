<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;	

switch($_POST['task']){	

case "updatePreport": /* pos report */
	$key = $_POST['key'];
	$val = $_POST['val'];
	$crid = $_POST['crid'];
	$q = "UPDATE {$dbg}.05_promotions SET `$key` = '$val' WHERE `crid` = '$crid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;


	
default:
	break;

	
		
	

}	/* switch */




	

	
