<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;	

switch($_POST['task']){	

case "updateCav": /* cav */
	$dbg=PDBG;	
	$gid = $_POST['gid'];
	$key = $_POST['key'];
	$val = $_POST['val'];
	$crid = $_POST['crid'];
	$q = "UPDATE {$dbg}.50_grades SET `$key` = '$val' WHERE `id` = '$gid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
case "updateGenave": /* cav genave */
	$dbg=PDBG;$dbg=PDBG;	
	$scid = $_POST['scid'];
	$key = $_POST['key'];
	$val = $_POST['val'];
	$crid = $_POST['crid'];
	$q = "UPDATE {$dbg}.05_summaries SET `$key` = '$val' WHERE `scid` = '$scid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;	


	
default:
	break;

	
		
	

}	/* switch */




	

	
