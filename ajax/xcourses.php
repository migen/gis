<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg=PDBG;


switch($_POST['task']){

case "xeditCourse":
	$dbg=PDBG;
	$row=$_POST;
	$id=$row['course_id'];
	$row['name']=$row['crname'].'-'.$row['label'];	
	unset($row['course_id']);
	unset($row['task']);
	unset($row['task']);
	unset($row['crname']);	
	$where=" `id`='$id' ";
	$db->update("{$dbg}.05_courses",$row,$where);		
	break;

case "xeditCrsPos":
	$crsid=$_POST['crsid'];$pos=$_POST['pos'];
	$q="UPDATE {$dbg}.05_courses SET `position`='$pos' WHERE `id`='$crsid' LIMIT 1; ";
	$db->query($q);break;

	
case "xeditTcid":
	$crsid=$_POST['crsid'];$tcid=$_POST['tcid'];
	$q="UPDATE {$dbg}.05_courses SET `tcid`='$tcid' WHERE `id`='$crsid' LIMIT 1; ";
	$db->query($q);break;
	

case "xeditCrsTeac":
	$dbg=PDBG;	
	$crid=$_POST['crid'];$crsid=$_POST['crsid'];
	$tcid=$_POST['tcid'];$pos=$_POST['pos'];
	$course=$_POST['course'];
	$q="UPDATE {$dbg}.05_courses SET `tcid`='$tcid',`name`='$course',`position`='$pos' WHERE `id`='$crsid' LIMIT 1; ";
	$db->query($q);	
	
	/* 2 logs */
	$axn = $_SESSION['axn']['edit_course'];
	$details = "editCrsTeac";
	$ucid = $_SESSION['user']['ucid'];
	$more['crsid'] = $crsid;
	$more['crid'] = $crid;
	logThis($db,$ucid,$axn,$details,$more);					

	
	break;

	
default:
	break;

	
	
	
}	/* switch */




	
	