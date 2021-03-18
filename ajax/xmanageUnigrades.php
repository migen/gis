<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;$dbo=PDBO;

switch($_POST['task']){

case "xaddUnigrade":
	$scid=$_POST['scid'];$sem=$_POST['sem'];$crs=$_POST['crs'];
	$q = "INSERT INTO {$dbg}.10_grades (`scid`,`semester`,`course_id`)VALUES('$scid','$sem','$crs');";
	$db->query($q);		
	
	$q="SELECT * FROM {$dbg}.01_courses WHERE id='$crs' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);
	break;		


case "xaddStudentToUnicourse":
	$scid=$_POST['scid'];$sem=$_POST['sem'];$crs=$_POST['crs'];
	$q = "INSERT INTO {$dbg}.10_grades (`scid`,`semester`,`course_id`)VALUES('$scid','$sem','$crs');";
	$db->query($q);			
	$q="SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);
	break;		

	
default:
	break;

	
	

}	/* switch */




	

	
