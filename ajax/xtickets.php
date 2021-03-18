<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg	= PDBG;


switch($_POST['task']){

case "doTicket":
	$tid = $_POST['tid'];
	$ts = date('Y-m-d H:i:s');
	$dbg = PDBG;
	$q = "UPDATE {$dbg}.tickets SET `is_done`='1',`done`='$ts' WHERE `id` = '$tid' LIMIT 1; ";	
	$_SESSION['q'] = $q;	
	$db->query($q);	
	break;

case "undoTicket":
	$tid = $_POST['tid'];
	$dbg = PDBG;	
	$q = "UPDATE {$dbg}.tickets SET `is_done`='0',`done`=null WHERE `id` = '$tid' LIMIT 1; ";	
	$db->query($q);	
	$_SESSION['q'] = $q;	
	break;
	
case "openCourse":
	$crsid 	= $_POST['crsid'];
	$qtr 	= $_POST['qtr'];
	$tid 	= $_POST['tid'];
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '0',`finalized_date_q{$qtr}` = ''				
			WHERE `course_id` = '".$crsid."' LIMIT 1; ";
	
	/* 2 */
	$ts = date('Y-m-d H:i:s');
	$q .= "UPDATE {$dbg}.tickets SET `is_done`='1',`done`='$ts' WHERE `id` = '$tid' LIMIT 1; ";	
	$db->query($q);
		
	/* 3 */
	$q = "SELECT crs.name AS course,tc.name AS teacher,tc.id AS tcid,crs.crid AS crid,cr.name AS classroom,
			ac.name AS adviser,ac.id AS acid 
			FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id			
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id			
			LEFT JOIN {$dbo}.`00_contacts` AS ac ON cr.acid = ac.id			
		WHERE crs.id = '$crsid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$course = $sth->fetch();	
	$crid = $course['crid'];
	$crname = $course['classroom'];
	$_SESSION['q'] = $q;
	
	/* 3 */
	$axn = $_SESSION['axn']['open_course'];
	$details = "Q{$qtr} - ".$course['course']." - ".$course['teacher'];
	$ucid = $_SESSION['user']['ucid'];

	$more['qtr'] = $qtr;	
	$more['crsid'] = $crsid;
	$more['ecid'] = $course['tcid'];			
	logThis($db,$ucid,$axn,$details,$more);			

/* 4 */	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q{$qtr}` = '0',`finalized_date_q{$qtr}` = ''				
			WHERE `crid` = '".$course['crid']."' LIMIT 1; ";
	$_SESSION['q'] .= $q;
	$db->query($q);
	
/* 5 */	
	$axn = $_SESSION['axn']['open_classroom'];
	$details = "Q{$qtr} - ".$crname." - ".$course['adviser'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crid'] = $crid;
	$more['ecid'] = $course['acid'];			
	logThis($db,$ucid,$axn,$details,$more);				
	break;

	
case "openClassroom":
	$crid 	= $_POST['crid'];
	$qtr 	= $_POST['qtr'];
	$tid 	= $_POST['tid'];
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q{$qtr}` = '0',`finalized_date_q{$qtr}` = ''				
			WHERE `crid` = '".$crid."' LIMIT 1; ";
	
	/* 2 */
	$ts = date('Y-m-d H:i:s');
	$q .= "UPDATE {$dbg}.tickets SET `is_done`='1',`done`='$ts' WHERE `id` = '$tid' LIMIT 1; ";	
	$db->query($q);
	$_SESSION['q'] = $q;

	/* 2 */
	$q = "SELECT cr.acid,cr.name AS classroom,c.name AS adviser 
			FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id			
		WHERE cr.id = '$crid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$classroom = $sth->fetch();		
	
	/* 3 */
	$axn = $_SESSION['axn']['open_classroom'];
	$details = "Q{$qtr} - ".$classroom['classroom']." - ".$classroom['adviser'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crid'] = $crid;
	$more['ecid'] = $classroom['acid'];			
	logThis($db,$ucid,$axn,$details,$more);			
	break;
	
		
default:
	break;

	
	

}	/* switch */




	

	



