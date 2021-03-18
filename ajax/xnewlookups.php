<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;	



switch($_POST['task']){	

case "addlookupvalue": /* pos report */
	$tbl = $_POST['tbl'];
	$val = $_POST['val'];
	$q = "INSERT INTO {$dbo}.{$tbl} (`name`) VALUES ('$val'); ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

	
	
default:
	break;

	
		
	

}	/* switch */




	

	
