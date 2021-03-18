<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;	


switch($_POST['task']){

case "xpayPos": /* pos report */
	$pos_id = $_POST['posid'];
	$q = "UPDATE {$dbo}.`30_pos` SET `is_paid` = '1' WHERE `id` = '$pos_id' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xunpayPos": /* pos report */
	$dbg	= PDBG;	
	$pos_id = $_POST['posid'];
	$q = "UPDATE {$dbo}.`30_pos` SET `is_paid` = '0' WHERE `id` = '$pos_id' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
		
default:
	break;

	
	

}	/* switch */




	

	
