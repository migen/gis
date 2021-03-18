<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
include_once('../library/Functions.php');		


$dbo=PDBO;


switch($_POST['task']){



case "updateUserOrno":
	$ucid=$_SESSION['ucid'];	
	$post=$_POST;
	extract($post);	
	$q="UPDATE {$dbo}.03_orbooklets SET orno='$orno' WHERE ecid=$ucid LIMIT 1;";
	$_SESSION['q'] = $q;
	$db->query($q);		
	break;

case "cancelOrno":
	$post=$_POST;
	extract($post);	

	// 1 - getRow
	$q="SELECT p.*,c.name AS studname,ft.name AS feetype
		FROM $dbtable AS p 
		INNER JOIN {$dbo}.00_contacts AS c ON c.id=p.scid
		INNER JOIN {$dbo}.03_feetypes AS ft ON ft.id=p.feetype_id
		WHERE p.id=$pkid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	
	// 2 - log
	require_once(SITE.'functions/logs.php');
	$studname=$row['studname'];
	$feetype=$row['feetype'];
	$sydetails = ($row['sy']!=DBYR)? " for SY".$row['sy']:NULL;
	$logdetails="{$studname} - orno cancel of ".$row['amount']." for {$feetype}{$sydetails}";
	textlog($db,$module_id=2,$logdetails,$row['sy']);	

	// 3 - 
	$notes="Cancelled OR of P".number_format($row['amount'],2)." on ".$_SESSION['date'];
	$q="UPDATE $dbtable SET `amount`=0,`received`=0,`change`=0,`notes`='$notes' WHERE id=$pkid LIMIT 1;";
	$db->query($q);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
