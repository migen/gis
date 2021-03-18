<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;


switch($_POST['task']){


case "xdeleteGrade":
	$q = " DELETE FROM {$dbg}.50_grades WHERE `id` = '".$_POST['gid']."' LIMIT 1;  ";
	$db->querysoc($q);
	break;


case "saveGrade":
	$row=$_POST;	
	$sy=$_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;$id=$row['id'];
	unset($row['task']);unset($row['id']);unset($row['sy']);
	$db->update("{$dbg}.`50_grades`",$row," `id`=$id ");
	break;



	
default:
	break;

	
	

}	/* switch */




	

	
