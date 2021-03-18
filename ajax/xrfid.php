<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	


case "xgetContactsBySwitch":
	$value=$_POST['value'];
	$limit=$_POST['limit'];
	$limitcond=($limit==0)? NULL:" LIMIT $limit";

	$tasktype=$_POST['tasktype'];
	if($tasktype==1){
		$q="SELECT * FROM {$dbo}.`00_contacts` WHERE `rfid` = '".$value."' ORDER BY `name` $limitcond;  ";		
	} else {
		$q="SELECT * FROM {$dbo}.`00_contacts` WHERE code LIKE '%".$value."%' OR name LIKE '%".$value."%' 
			ORDER BY `name` $limitcond;  ";		
	}	
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;



case "assignRfid":
	$value=$_POST['value'];$scid=$_POST['scid'];
	$q="UPDATE {$dbo}.`00_contacts` SET rfid='$value' WHERE id=$scid LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;

	
default:
	break;

	
		
	

}	/* switch */




	

	


