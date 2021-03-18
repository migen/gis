<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){

case "xdelCpos":
	$q="SELECT * FROM ".PDBG.".poscredits WHERE `id`='".$_POST['cposid']."' LIMIT 1; ";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	echo json_encode($row);
	
	$q = " DELETE FROM ".PDBG.".poscredits WHERE id = '".$_POST['cposid']."' LIMIT 1; ";
	$db->query($q);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
