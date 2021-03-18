<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){

case "xeditCodename":
	/* 2 */
	$q = " UPDATE {$dbo}.`00_contacts` SET  `code` = '".$_POST['code']."',`account` = '".$_POST['code']."'
		WHERE `id` = '".$_POST['ucid']."' LIMIT 1;";
	$db->query($q);		
	$_SESSION['q'] = $q;		
	break;
	
default:
	break;

	
	
}	/* switch */




	
	