<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


switch($_POST['task']){	

case "finalizeCashTally": /* pos report */
	$dbg = PDBG;	
	$cid = $_POST['cid'];
	$q = "UPDATE {$dbg}.`30_cash` SET `is_finalized` = '1' WHERE `id` = '$cid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "openCashTally": /* pos report */
	$dbg = PDBG;	
	$cid = $_POST['cid'];
	$q = "UPDATE {$dbg}.`30_cash` SET `is_finalized` = '0' WHERE `id` = '$cid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

	
	
default:
	break;

	
		
	

}	/* switch */




	

	
