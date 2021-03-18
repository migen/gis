<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;


switch($_POST['task']){


case "xgetProduct":
	$prid=$_POST['prid'];
	$q = "SELECT * FROM {$dbo}.`03_products` WHERE `id` = '$prid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
