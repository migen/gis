<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){


case "getPhoto":
	$q = " SELECT * FROM ".DBP.".photos WHERE `contact_id` = '".$_POST['ucid']."' LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
