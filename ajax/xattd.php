<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){

case "deleteAtte":
	$dbg=PDBG;
	
	$q = " DELETE FROM "{$dbg}.attendance_employees_logs" WHERE id = '".$_POST['attid']."' LIMIT 1; ";
	$db->querysoc($q);
	$_SESSION['q'] = $q;
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
