<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



$dbg=PDBG;

switch($_POST['task']){


case "xgetLevels":
	$q="SELECT id,code,name FROM {$dbo}.`05_levels` ORDER BY id; ";
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	echo json_encode($rows);	
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
