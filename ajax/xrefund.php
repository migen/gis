<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;	

switch($_POST['task']){	


case "ovrefund": /* pos report */
	$scid = $_POST['scid'];
	$amt = $_POST['amt'];
	$today=$_SESSION['today'];
	$ovrid=$_SESSION['ovrid'];
	$q = "INSERT INTO {$dbg}.`30_auxes`(`scid`,`feetype_id`,`num`,`amount`,`due`)VALUES('$scid','$ovrid','1','$amt','$today'); ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

	
default:
	break;

	
		
	

}	/* switch */




	

	
