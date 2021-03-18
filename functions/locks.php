<?php


function lockCourse($db,$course_id,$qtr,$dbg=PDBG){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;
	/* 1 */
	$today = $_SESSION['today'];		
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q$qtr` = 1,`finalized_date_q$qtr` = '$today' 
	WHERE `course_id` = '$course_id' LIMIT 1; "; 
	$db->query($q);				
	
	/* 2 */
	$q = "SELECT crs.name AS course,tc.name AS teacher,tc.id AS tcid 
			FROM {$dbg}.05_courses AS crs 
		LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id			
		WHERE crs.id = '$course_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$course = $sth->fetch();	
	
	/* 3 */
	$axn = $_SESSION['axn']['lock_course'];
	$details = "Q{$qtr} - ".$course['course']." - ".$course['teacher'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crsid'] = $course_id;
	$more['ecid'] = $course['tcid'];		
	logThis($db,$ucid,$axn,$details,$more);	
	
}	/* fxn */


function unlockCourse($db,$course_id,$qtr,$dbg=PDBG){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;
	/* 1 */
	$q  = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q$qtr` = 0 WHERE `course_id` = '$course_id' LIMIT 1; "; 
	$db->query($q);				
	
	/* 2 */
	$q = "SELECT crs.name AS course,tc.name AS teacher,tc.id AS tcid 
			FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id			
		WHERE crs.id = '$course_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$course = $sth->fetch();	
	
	/* 3 */
	$axn = $_SESSION['axn']['open_course'];
	$details = "Q{$qtr} - ".$course['course']." - ".$course['teacher'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crsid'] = $course_id;
	$more['ecid'] = $course['tcid'];	
	logThis($db,$ucid,$axn,$details,$more);	
	
	
}	/* fxn */


function lockClassroom($db,$crid,$qtr,$dbg=PDBG){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;
	$today = $_SESSION['today'];		
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = 1,`finalized_date_q$qtr` = '$today' 
		WHERE `crid` = '$crid' LIMIT 1; "; 
	$db->query($q);				
	
	/* 2 */
	$q = "SELECT cr.acid,cr.name AS classroom,c.name AS adviser 
			FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id			
		WHERE cr.id = '$crid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$classroom = $sth->fetch();		
	$_SESSION['q'] = $q;
	
	/* 3 */
	$axn = $_SESSION['axn']['lock_classroom'];
	$details = "Q{$qtr} - ".$classroom['classroom']." - ".$classroom['adviser'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crid'] = $crid;
	$more['ecid'] = $classroom['acid'];	
	logThis($db,$ucid,$axn,$details,$more);	
	
	
}	/* fxn */

function unlockClassroom($db,$crid,$qtr,$dbg=PDBG){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;

	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = '0' WHERE `crid` = '$crid' LIMIT 1; "; 
	$db->query($q);				
	
	/* 2 */
	$q = "SELECT cr.acid,cr.name AS classroom,c.name AS adviser 
			FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id			
		WHERE cr.id = '$crid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$classroom = $sth->fetch();		
	$_SESSION['q'] = $q;
	
	/* 3 */
	$axn = $_SESSION['axn']['open_classroom'];
	$details = "Q{$qtr} - ".$classroom['classroom']." - ".$classroom['adviser'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $qtr;
	$more['crid'] = $crid;
	$more['ecid'] = $classroom['acid'];
	logThis($db,$ucid,$axn,$details,$more);	
	
}	/* fxn */




function lockAttendance($db,$crid,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = '1' WHERE `crid` = '$crid' LIMIT 1; "; 
	$db->query($q);				
}	/* fxn */


function unlockAttendance($db,$crid,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = '0' WHERE `crid` = '$crid' LIMIT 1; "; 
	$db->query($q);				
}	/* fxn */




function cq($db,$level_id,$cond=true,$dbg=PDBG){		/* courses_quarters by subjectsCoor,title-10,4-1 */
  $dbo=PDBO;
  $where = "";	  
  $q = "SELECT crs.id AS course_id,crs.name AS course,crs.crstype_id AS ctype_id,crs.crid AS crid,crs.*,
			l.name AS level,sec.name AS section,
			c.id AS tcid,c.account,c.name AS teacher,cp.`ctp` AS pass,
            cq.id AS cqid,cq.*
		FROM {$dbg}.05_courses AS crs 
            LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id 
            LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id 
            LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id 
            LEFT JOIN {$dbg}.05_courses_quarters AS cq ON crs.id = cq.course_id 
            LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id 
            LEFT JOIN {$dbo}.`00_ctp` AS cp ON crs.tcid = cp.contact_id 					
 		WHERE crs.is_active=1 AND cr.level_id=$level_id $where 
		ORDER BY crs.crid,crs.position,crs.id; ";
	debug($q);
	$sth = $db->querysoc($q);
	$data['cq'] = $sth->fetchAll();
	$data['num_cq'] = $sth->rowCount();
	return $data;

}	/* fxn */



function aq($db,$level_id,$cond=true,$dbg=PDBG){	/* courses_quarters by advisersCoor,title-12,4-3 */
  $dbo=PDBO;
  $where = "";
  $q = "SELECT cr.*,aq.*,cr.id AS 'crid',cr.`name` AS 'classroom',cr.acid AS acid,
			c.account,c.name AS adviser,cp.`ctp` AS pass,aq.id AS aqid,
			prom.is_finalized AS prom_finalized
		FROM {$dbg}.05_classrooms AS cr 
            LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON cr.id = aq.crid 
            LEFT JOIN {$dbg}.05_promotions AS prom ON prom.crid = cr.id 
            LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id 
            LEFT JOIN {$dbo}.`00_ctp` AS cp ON cr.acid = cp.contact_id 		
		WHERE cr.level_id=$level_id $where	
		ORDER BY cr.level_id ASC,cr.section_id ASC; ";	 	 
	$sth = $db->querysoc($q);
	$data['aq'] 	= $sth->fetchAll();
	$data['num_aq'] = $sth->rowCount();
	return $data;

}	/* fxn */

 

