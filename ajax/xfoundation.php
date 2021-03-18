<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



$sy=isset($_POST['sy'])? $_POST['sy']:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;

switch($_POST['task']){

case "toggleFoundation":
	$sub=$_POST['sub'];$val=$_POST['val'];
	$q = " UPDATE {$dbo}.`05_subjects` SET `is_foundation`= '$val' WHERE `id` = '$sub' LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->query($q);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
