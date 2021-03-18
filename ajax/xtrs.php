<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){

case "deleteTrs":
	$trsid = $_POST['trsid'];
	$dbg=PDBG;
	$q="DELETE FROM {$dbg}.50_trsgrades WHERE `id`='$trsid' LIMIT 1; ";
	$db->querysoc($q);
	break;
	
case "editTrsgrade":
	$qtr = $_POST['qtr'];
	$grade = $_POST['grade'];
	$trsid = $_POST['trsid'];
	$dbg=PDBG;
	$q="UPDATE {$dbg}.50_trsgrades SET `q{$qtr}`='$grade' WHERE `id`='$trsid' LIMIT 1; ";
	$db->querysoc($q);
	break;

	
	
default:
	break;

	
	

}	/* switch */




	

	



