<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){


	
case "xgetStudentsByPartClubs":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT c.id,c.name,c.code,c.account,c.parent_id,c.role_id,c.privilege_id,summ.club_id,cl.name AS `club`
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
		LEFT JOIN {$dbg}.05_clubs AS cl ON summ.club_id=cl.id 
		WHERE c.`role_id`='".RSTUD."' AND (c.`code` LIKE '%".$part."%' 
		OR c.`account` LIKE '%".$part."%' OR c.`name` LIKE '%".$part."%') 
		ORDER BY c.`name` LIMIT $limits;  ";		
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




	

	
