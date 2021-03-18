<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

// rfid, before epc

$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	

case "xgetContactsByRfid":
	$part=$_POST['part'];$limit=10;
	$q="SELECT c.id,c.name,code,c.parent_id,c.role_id,c.privilege_id 
		FROM {$dbo}.`00_contacts` AS c
		WHERE c.`rfid` LIKE '%".$part."%' 
		ORDER BY c.`name` LIMIT $limit;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;


case "xgetContactsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT c.id,c.name,code,c.parent_id,summ.crid,c.role_id,c.privilege_id 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE c.`name` LIKE '%".$part."%' OR c.`account` LIKE '%".$part."%' 
		OR c.`code` LIKE '%".$part."%' ORDER BY c.`name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);		
	echo json_encode($rows);
	break;

	
case "xgetContactsByCode":
	$part = $_POST['part'];
	$limits = $_POST['limits'];	

	$q = " SELECT c.id,c.name,code,summ.crid,c.role_id,c.privilege_id 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE c.`name` LIKE '%".$part."%' OR c.`account` LIKE '%".$part."%' 
		OR c.`code` LIKE '%".$part."%' ORDER BY c.`name` LIMIT $limits;  ";		
		
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;
		

case "xgetContactByCode":
	$code = $_POST['code'];
		
	$q = " SELECT c.id,c.name,code,c.parent_id,summ.crid,c.role_id,c.privilege_id 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE `code` = '".$code."' OR `account` = '".$code."' LIMIT 1;  ";		
		
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;

case "xgetContactByID":
	$pcid = $_POST['pcid']; 
	$q = " SELECT pc.id,pc.code,pc.name,pc.name AS fullname,pc.id AS parent_id,pc.id AS pcid,c.prevcrid,pc.role_id 
			FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id 
		WHERE c.`id` = '".$pcid."' LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	// $row['name'] = utf8_encode($row['name']);	
	echo json_encode($row);
	break;


case "xgetContactByUcid":
	$ucid = $_POST['ucid'];
	$q = " SELECT id,name,code,parent_id FROM {$dbo}.`00_contacts` WHERE `id` = '".$ucid."' LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;
	

case "xgetStudentByUcid":
	$ucid = $_POST['ucid'];
	$q = " SELECT c.name AS student,c.*,cr.acid AS acid FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE c.`id` = '".$ucid."' LIMIT 1;  ";
		
	$_SESSION['q'] = 'functions/xgetContacts : '.$q;	
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
default:
	break;

	
		
	

}	/* switch */




	

	
