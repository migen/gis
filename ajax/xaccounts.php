<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");


$dbo=PDBO;

switch($_POST['task']){	


case "xgetFeeAmount":	
	$feeid = $_POST['feeid'];
	$q = " SELECT * FROM {$dbo}.`03_feetypes` WHERE `id`='$feeid' LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	

	
default:
	break;

	
		
	

}	/* switch */




	

	
