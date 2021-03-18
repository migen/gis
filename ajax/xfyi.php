<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbtable	= $_POST['dbtable'];
$column		= $_POST['column'];
$qval		= $_POST['qval'];



switch($_POST['task']){

case "equal":
	$q = " SELECT * FROM {$dbtable} WHERE `{$column}` = '{$qval}' LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;

case "like":
	$q = " SELECT * FROM {$dbtable} WHERE `{$column}` LIKE '%{$qval}%' LIMIT 100;  ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;

	
	
default:
	break;

	
	

}	/* switch */




	

	
