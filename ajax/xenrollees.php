<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){



case "removeCurrentEnrollee":
	$scid=$_POST['scid'];
	$sy=DBYR-1;
	$q = " UPDATE {$dbo}.`00_contacts` SET `sy`='$sy' WHERE `id`='$scid' LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->querysoc($q);
	break;



	
default:
	break;






}	/* switch */


