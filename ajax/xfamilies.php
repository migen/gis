<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo = PDBO;

$task=isset($_POST['task'])? $_POST['task']:'test';

switch($task){

case "exists":
	$post=$_POST;
	extract($post);
	$q="SELECT m.id,m.family_id,f.name AS family FROM $dbtable AS m
		LEFT JOIN {$dbo}.00_families AS f ON m.family_id=f.id 
		WHERE m.scid=$scid LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$row['exists']=(!empty($row))? true:false;
	echo json_encode($row);	
	break;

	
	
default:
	break;








}	/* switch */

