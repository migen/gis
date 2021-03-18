<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;

switch($_POST['task']){

case "xdeletePx":
	$pxid = $_POST['pxid'];
	$q="DELETE FROM {$dbo}.`30_po_rx` WHERE id='$pxid' LIMIT 1; ";
	$_SESSION['q'] = $q;	
	$db->query($q);	
	break;
	
		
default:
	break;

	
	

}	/* switch */




	

	



