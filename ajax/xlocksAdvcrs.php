<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$id = $_POST['id'];
$dbg=PDBG;

switch($_POST['task']){

case "xlockerCourse":
	$crs = $_POST['crs'];
	$qtr = $_POST['qtr'];
	$is_locked = $_POST['is_locked'];
	$q = " UPDATE {$dbg}.`05_courses_quarters` SET `is_finalized_q{$qtr}`='$is_locked' WHERE `course_id`='$crs' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;



case "xdelrow":
	$dbtbl = $_POST['dbtbl'];
	$id	   = $_POST['id'];
	$q = " DELETE FROM $dbtbl WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;
	
	
default:
	$row = array('code'=>'defcode','name'=>'defname');
	echo json_encode($row);	
	break;







}	/* switch */


