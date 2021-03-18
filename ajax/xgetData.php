<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	
	

case "xgetDataByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$dbtable = $_POST['dbtable'];

	$q="SELECT id,code,name FROM $dbtable WHERE `code` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' LIMIT $limits; ";		
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;	

case "xgetDataByPartNameOnly":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$dbtable = $_POST['dbtable'];

	$q="SELECT id,name FROM $dbtable WHERE `name` LIKE '%".$part."%' LIMIT $limits; ";		
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




	

	
