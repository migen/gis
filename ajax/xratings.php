<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



$dbg = PDBG;


switch($_POST['task']){


case "deleteEquiv":
	$q = " DELETE FROM {$dbg}.05_equivalents WHERE `id` = '".$_POST['eid']."' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "deleteRating":
	$q = " DELETE FROM {$dbg}.05_descriptions WHERE `id` = '".$_POST['did']."' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
default:
	break;

	
	

}	/* switch */




	

	
