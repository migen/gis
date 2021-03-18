<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		




$dbg = PDBG;

switch($_POST['task']){

case "xgetUcidByTerminal":
	$ip = $_POST['ip'];
	$q = "SELECT c.id,c.code,c.name,b.balance
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.balances AS b ON b.contact_id = c.id
			LEFT JOIN {$dbo}.terminals AS t ON t.ucid = c.id
		WHERE t.`ip` = '$ip' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;


case "xgetUcid":
	$tid = $_POST['tid'];
	$q = " SELECT `ucid` FROM {$dbo}.terminals WHERE `id` = '$tid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
	
default:
	break;

	
	

}	/* switch */




	

	
