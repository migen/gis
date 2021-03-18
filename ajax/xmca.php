<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg=PDBG;

switch($_POST['task']){

case "xeditAq":
	$today	= $_SESSION['today'];
	$acrid 	= $_POST['acrid'];
	$row 	= $_POST;
	$qtr 	= $_POST['qtr'];
	$sy 	= $_POST['sy'];
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`is_finalized_q1` = '".$row['aq1']."',
				`is_finalized_q2` = '".$row['aq2']."',
				`is_finalized_q3` = '".$row['aq3']."',
				`is_finalized_q4` = '".$row['aq4']."',
				`is_finalized_q5` = '".$row['aq5']."',
				`is_finalized_q6` = '".$row['aq6']."',
				`finalized_date_q{$qtr}` = '$today'				
			WHERE `crid` = '".$acrid."' LIMIT 1;
	";
	$q .= " UPDATE {$dbg}.05_classrooms SET 
				`is_finalized_honors` = '0'
			WHERE id = '".$acrid."' LIMIT 1;
	";	
	$_SESSION['q']=$q.' - '.$dbg;
	$db->query($q);

	/* 2 */
	$q = "SELECT cr.acid,cr.name AS classroom,c.name AS adviser 
			FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id			
		WHERE cr.id = '$acrid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$classroom = $sth->fetch();		
	// $_SESSION['q'] = $q;
	
	/* 3 */
	$axn = $_SESSION['axn']['open_classroom'];
	$details = "MCA - ".$classroom['classroom']." - ".$classroom['adviser'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['crid'] = $acrid;
	$more['ecid'] = $classroom['acid'];			
	logThis($db,$ucid,$axn,$details,$more);		
	
	break;

case "xeditCq":
	$today		= $_SESSION['today'];
	$crid 		= $_POST['crid'];
	$crsid 		= $_POST['crsid'];
	$supsubjid 	= $_POST['supsubjid'];
	
	$ssy 	= $_SESSION['sy'];
	$qtr 	= $_POST['qtr'];
	$sy 	= $_POST['sy'];
	$sqtr   = $_SESSION['qtr'];
	$dbg	= VCPREFIX.$sy.US.DBG;
	$dbg	= VCPREFIX.$sy.US.DBG;		
	$row 	= $_POST;	
	
	
	/* 1 */
	$q = "SELECT * FROM {$dbg}.05_courses WHERE `id` = '$crsid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$course = $sth->fetch();

	$expr = "q1";
	for($i=2;$i<=$sqtr;$i++){ $expr .= "+q$i"; }		

	$q = "";	
	$q .= "UPDATE {$dbg}.50_grades SET q5 = ($expr)/$sqtr WHERE `course_id` = '$crsid' LIMIT 1;";		
	if($course['semester']==1){
		$expr = ($sqtr%2)? 'q1':'q1+q2';
		$num = ($sqtr%2)? 1:2;
		$q .= " UPDATE {$dbg}.50_grades SET q5 = ($expr)/$num WHERE `course_id` = '$crsid' LIMIT 1; ";		
	} elseif($course['semester']==2){
		if($sqtr>2){
			$q .= "UPDATE {$dbg}.50_grades SET q5 = (q1+q2)/2 WHERE `course_id` = '$crsid' LIMIT 1; ";

			/* sem2 */
			$expr = ($sqtr%2)? 'q3':'q3+q4';
			$num = ($sqtr%2)? 1:2;
			$q .= "UPDATE {$dbg}.50_grades SET q6 = ($expr)/$num WHERE `course_id` = '$crsid' LIMIT 1; ";
		
		}		
	}	/* sem=2 */
	
		
	
	/* 2 - crid */
	$q .= " UPDATE {$dbg}.05_advisers_quarters SET 
				`is_finalized_q{$qtr}` = '0',
				`finalized_date_q{$qtr}` = '$today'								
			WHERE `crid` = '".$crid."' LIMIT 1;
	";
	
	/* 2 - this course */
	$q .= " UPDATE {$dbg}.05_courses_quarters SET 
				`is_finalized_q1` = '".$_POST['cq1']."',
				`is_finalized_q2` = '".$_POST['cq2']."',
				`is_finalized_q3` = '".$_POST['cq3']."',
				`is_finalized_q4` = '".$_POST['cq4']."',
				`is_finalized_q5` = '".$_POST['cq5']."',
				`is_finalized_q6` = '".$_POST['cq6']."',
				`finalized_date_q{$qtr}` = '$today'												
			WHERE `course_id` = '".$crsid."' LIMIT 1;
	"; 		
	

	
	
	
	$db->query($q);	
	

	/* 2 */
	$q = "SELECT crs.name AS course,tc.name AS teacher,tc.id AS tcid 
			FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id			
		WHERE crs.id = '$crsid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$course = $sth->fetch();		
	
	/* 3 */
	$axn = $_SESSION['axn']['open_course'];
	$details = "MCA - ".$course['course']." - ".$course['teacher'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];	
	$more['crsid'] = $course_id;
	$more['ecid'] = $course['tcid'];			
	logThis($db,$ucid,$axn,$details,$more);	
	
	break;
	
case "xeditAttq":
	$acrid 	= $_POST['acrid'];
	$row 	= $_POST;
	$qtr 	= $_POST['qtr'];	
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`attendance_q1` = '".$row['attq1']."',
				`attendance_q2` = '".$row['attq2']."',
				`attendance_q3` = '".$row['attq3']."',
				`attendance_q4` = '".$row['attq4']."'
			WHERE `crid` = '".$acrid."' LIMIT 1;
	";
	$q .= " UPDATE {$dbg}.05_classrooms SET 
				`is_finalized_honors` = '0'
			WHERE id = '".$acrid."' LIMIT 1;
	";
	
	$sth = $db->query($q);
	$_SESSION['q'] = $q;
	break;
		

case "xeditCdtLocking":
	$acrid 	= $_POST['acrid'];
	$row 	= $_POST;
	extract($row);
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`conduct_q1` = '".$cdtq1."',
				`conduct_q2` = '".$cdtq2."',
				`conduct_q3` = '".$cdtq3."',
				`conduct_q4` = '".$cdtq4."'
			WHERE `crid` = '".$acrid."' LIMIT 1;
	";
	
	$sth = $db->query($q);
	$_SESSION['q'] = $q;
	break;


case "xeditPromotionLocking":
	$acrid 	= $_POST['acrid'];
	$row 	= $_POST;
	$qtr 	= $_POST['qtr'];	
	$ifp 	= $_POST['ifp'];	
	
	$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '$ifp' WHERE `crid` = '".$acrid."' LIMIT 1;";	
	$sth = $db->query($q);
	$_SESSION['q'] = $q;
	break;

		
default:
	break;

	
	

}	/* switch */




	

	
