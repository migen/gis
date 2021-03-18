<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg = PDBG;	
$dbo = PDBO;	


switch($_POST['task']){

case "xDelTerminal": /* pos report */
	$pkid = $_POST['pkid'];
	$q = "DELETE FROM {$dbo}.`03_terminals_employees` WHERE `id` = '$pkid' LIMIT 1; ";
	$db->querysoc($q);
	$_SESSION['q'] = $q;
	$_SESSION['message'] = "Terminal deleted.";	
	break;

	
	
		
default:
	break;

	
	

}	/* switch */




	

	
