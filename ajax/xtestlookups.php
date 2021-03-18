<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){


case "xgetContactsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.`00_contacts` WHERE `code` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' 
		ORDER BY `name` LIMIT $limits;  ";		
	$_SESSION['q'] = $q;	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);	
	echo json_encode($rows);
	break;

case "xgetPersonsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.`persons` WHERE `code` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' 
		ORDER BY `name` LIMIT $limits;  ";		
	$_SESSION['q'] = $q;	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);	
	
	echo json_encode($rows);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
