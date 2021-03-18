<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;


switch($_POST['task']){

case "xgetRowsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.animals WHERE `name` LIKE '%".$part."%' ORDER BY name;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q'] = $rows;		
	echo json_encode($rows);
	break;


case "xgetCol":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$id=$_POST['id'];
	$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id='$id' LIMIT 2;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q'] = $rows;		
	echo json_encode($rows);
	break;


case "xgetRow":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id=12 LIMIT 2;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q'] = $rows;		
	echo json_encode($rows);
	break;
	
case "xgetContactsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,name,code,account
		FROM {$dbo}.`00_contacts` WHERE `code` LIKE '%".$part."%' 
		OR `account` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' 
		ORDER BY `name` LIMIT $limits;  ";				
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q'] = $rows;	
	echo json_encode($rows);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
