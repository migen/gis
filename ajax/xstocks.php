<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;


switch($_POST['task']){


case "xsaveQty":
	$prid = $_POST['prid'];
	$trml = $_POST['trml'];
	$tq = $_POST['tq'];
	$lq = $_POST['lq'];
	$cost = $_POST['cost'];
	$price = $_POST['price'];
	$q = "UPDATE {$dbo}.`03_products` SET `t{$trml}`='$tq',`level`='$lq',`cost`='$cost',`price`='$price' 
		WHERE `id` = '$prid' LIMIT 1; ";	
	// $q = "UPDATE {$dbo}.`03_products` SET `cost`='$cost',`price`='$price' 
		// WHERE `id` = '$prid' LIMIT 1; ";	

	$_SESSION['q'] = $q;	
	$db->query($q);	
	break;
	
		
default:
	break;

	
	

}	/* switch */




	

	



