<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo = PDBO;

switch($_POST['task']){


case "getContactByUid":
	$uid=$_POST['uid'];
	$q=" SELECT * FROM rfid.`00_contacts` WHERE uid='$uid' LIMIT 1 ; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);	
	$_SESSION['q'] = $q;
	break;
	
	
default:
	break;








}	/* switch */


