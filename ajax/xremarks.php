<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;
$dbg = PDBG;

switch($_POST['task']){

case "saveRemarksScid":	
	$scid=$_POST['scid'];
	unset($_POST['scid']);unset($_POST['task']);
	$post=$_POST;
	$db->update("{$dbg}.50_remarks",$post,"scid='$scid'");	
	$db->query($q);		
	break;
	
default:
	break;
	

}	/* switch */




	
	