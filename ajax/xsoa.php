<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg	= PDBG;		


switch($_POST['task']){
 
case "xsaveTsumRemarks":
	$remarks = $_POST['remarks'];
	$scid = $_POST['scid'];
	$q = " UPDATE {$dbg}.03_tsummaries SET `remarks` = ? WHERE `scid` = ? LIMIT 1 ; ";	
	$sth=$db->prepare($q);
	$sth->execute([$remarks,$scid]);    
	$_SESSION['q'] = $q;
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
