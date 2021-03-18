<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;
$dbo = PDBO;


switch($_POST['task']){

case "xgetRolesBySearch":
	// $rows=array( array('id'=>1,'name'=>'Makol'),array('id'=>2,'name'=>'Barry'));
	$search=$_POST['search'];
	$q="SELECT * FROM {$dbo}.`00_roles` WHERE name LIKE '%".$search."%' LIMIT 2; ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q1']=$rows;
	echo json_encode($rows);	
	break;

case "xgetRowsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	// $table = $_POST['table'];
	// $q = " SELECT * FROM {$dbo}.{$table} WHERE `name` LIKE '%".$part."%' ORDER BY name;  ";		
	$q = " SELECT * FROM {$dbo}.`00_roles` WHERE `name` LIKE '%".$part."%' ORDER BY name;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q1'] = $rows;		
	echo json_encode($rows);
	break;


	
	
default:
	break;








}	/* switch */

