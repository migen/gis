<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;$dbg=PDBG;


switch($_POST['task']){


case "xgetNameById":
	$idno = $_POST['idno'];
	$lookup = $_POST['lookup'];
	$q = " SELECT id,code,account,name FROM {$lookup} 
		WHERE `id` = '".$idno."';  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$row['name'] = utf8_encode($row['name']);
	echo json_encode($row);
	break;


case "xgetNamesByPart":
	$part = $_POST['part'];
	$lookup = $_POST['lookup'];
	$limits = $_POST['limits'];
	$q = " SELECT id,code,account,name FROM {$lookup} WHERE 
		`code` LIKE '%".$part."%' OR `account` LIKE '%".$part."%' OR 
		`name` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);		
	echo json_encode($rows);
	break;

case "xgetProductsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,code,barcode,name,suppid FROM {$dbo}.`03_products` WHERE `barcode` LIKE '%".$part."%' 
		OR `name` LIKE '%".$part."%' OR `code` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;
	
/* 
	$results = array_map(function($r) {
	  $r['text'] = utf8_encode($r['text']);
	  return $r;
	}, $results);
	echo json_encode($results);
 */	
	
case "xgetContactsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,name,code,account,parent_id,role_id,privilege_id
		FROM {$dbo}.`00_contacts` WHERE `code` LIKE '%".$part."%' 
		OR `account` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' 
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
	
case "xgetStudentsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,name,code,account,parent_id,role_id,privilege_id
		FROM {$dbo}.`00_contacts` WHERE `role_id`='".RSTUD."' AND (`code` LIKE '%".$part."%' 
		OR `account` LIKE '%".$part."%' OR `name` LIKE '%".$part."%') 
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




	

	
