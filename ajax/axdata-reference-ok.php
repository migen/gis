<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;$dbg=PDBG;


switch($_POST['task']){


case "xgetData":
	$part=$_POST['part'];
	$limit=$_POST['limit'];
	$dbtable=$_POST['dbtable'];
	$q = " SELECT id,code,name
		FROM {$dbtable} WHERE `code` LIKE '%".$part."%' 
		OR `name` LIKE '%".$part."%' ORDER BY `name` LIMIT $limit;  ";		
	$_SESSION['q']="axdata: ".$q;	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$rows=array_map(function($r) {
	  $r['name']=utf8_encode($r['name']);
	  return $r;
	}, $rows);	
	echo json_encode($rows);
	break;

	
	
	
default:
	break;

	
	

}	/* switch */




	

	
