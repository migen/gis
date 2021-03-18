<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){


case "clsAdvi":
	$dbg	= PDBG;			
	
	$q = " SELECT id AS crid,acid,level_id FROM {$dbg}.05_classrooms  WHERE `id` = '".$_POST['crid']."' LIMIT 1; "				
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
