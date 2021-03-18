<?php


function k1_3($db,$dbg,$scid,$sy){
	$dbo=PDBO;
	$q = "SELECT sub.name AS course,sub.code AS subject_code,crs.name AS course,crs.label,crs.code AS course_code,
			g.id AS gid,g.course_id,g.id AS grade_id,g.*
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.50_grades AS g ON g.scid = c.id
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		WHERE g.scid='$scid' AND crs.is_active=1
		ORDER by crs.position,crs.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function student($db,$dbg,$sy,$scid,$fields=NULL){
	$dbo=PDBO;
	$q = "SELECT c.`id` AS `scid`,c.`code` AS `student_code`,c.`name` AS `student`,
			s.crid AS scrid,s.prevcrid AS prevcrid,sum.`crid` AS `crid`,sum.`id` AS `sumid`,sum.`crid` AS `crid`,c.`sy` AS sy,
			sum.`acid` AS acid,sum.ave_q1 AS ag1,sum.ave_q2 AS ag2,sum.ave_q3 AS ag3,sum.ave_q4 AS ag4,sum.ave_q5 AS agf,
			sum.ave_dg1 AS adg1,sum.ave_dg2 AS adg2,sum.ave_dg3 AS adg3,sum.ave_dg4 AS adg4,sum.ave_dg4 AS adgf,			
			sum.conduct_q1 AS cg1,sum.conduct_q2 AS cg2,sum.conduct_q3 AS cg3,sum.conduct_q4 AS cg4,sum.conduct_q5 AS cgf,
			sum.conduct_dg1 AS cdg1,sum.conduct_dg2 AS cdg2,sum.conduct_dg3 AS cdg3,sum.conduct_dg4 AS cdg4,sum.conduct_dg5 AS cdgf,	
			p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,cr.*,cr.name AS classroom,l.*,
			l.name AS level,sec.name AS section,sum.*,p.*,s.*,c.* $fields					
			FROM {$dbo}.`00_contacts` AS `c` 		
				LEFT JOIN {$dbo}.`00_profiles` AS `p` ON p.`contact_id` = c.id
				LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`
				LEFT JOIN {$dbg}.05_students AS `s` ON sum.`scid` = s.`contact_id`
				LEFT JOIN {$dbg}.05_classrooms AS `cr` ON sum.`crid` = cr.`id`
				LEFT JOIN {$dbo}.`05_levels` AS `l` ON cr.`level_id` = l.`id`
				LEFT JOIN {$dbo}.`05_sections` AS `sec` ON cr.`section_id` = sec.`id`
			WHERE c.`id`='$scid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row;


}	/* fxn */


function getClassroomDetails($db,$crid,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT aq.*,l.*,d.name AS department,l.name AS level,l.code AS lvlcode,sec.name AS section,sec.code AS sxncode,
		c.account AS login,c.code AS teacher_code,c.code AS adviser_code,c.name AS adviser,c.code AS adviser_code,
		cr.*,cr.id AS crid,cr.name AS classroom,l.department_id		
	FROM   {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		INNER JOIN {$dbo}.`05_departments` AS d ON l.department_id = d.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid = cr.id
	WHERE cr.id = '$crid' LIMIT 1; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



/* attd,traits,grades,conduct,conducts,psmapehs */
function summary($db,$dbg,$sy,$crid,$scid){	
$dbo=PDBO;
$q = "SELECT summ.id AS sumid,summ.*,l.name AS promlevel
	FROM {$dbg}.`05_summaries` AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id 
		LEFT JOIN {$dbo}.`05_levels` AS l ON summ.promlvl = l.id 
	WHERE summ.`scid` = '$scid' ;";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


/* rcard-chinese */
function sumo($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;
$q = "SELECT sumo.id AS sumoscid,sumo.*
	FROM {$dbg}.`summaries_other` AS sumo
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sumo.scid = c.id 
	WHERE sumo.`scid` = '$scid';";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



function attendance($db,$dbg,$sy,$scid){
$dbo=PDBO;
$q = "SELECT att.*,att.id AS attid,c.id AS scid,c.code AS student_code,c.name AS student 
	FROM {$dbg}.05_attendance as att INNER JOIN {$dbo}.`00_contacts` AS c ON att.scid 	= c.id	 			
	WHERE att.`scid`  = '$scid';";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function grades($db,$dbg,$sy,$crid,$scid,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }

$q = "SELECT tcon.id AS tcid,tcon.code AS teacher_code,tcon.name AS teacher,crs.label AS subject,crs.crid,
		crs.*,g.`id` AS `gid`,g.*		
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.50_grades AS g ON g.course_id = crs.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		LEFT JOIN {$dbo}.`00_contacts` AS tcon ON crs.tcid = tcon.id		
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1' AND crs.`crstype_id` <> ".CTYPETRAIT."   
		AND g.`scid`='$scid' $semester ORDER BY crs.position,crs.id ; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function traits($db,$dbg,$sy,$scid){
	$dbo=PDBO;
	$bq = " g.q1,g.q2,g.q3,g.q4,";
	$q = "SELECT cri.name AS trait,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id, 
			$bq g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id`	  		= crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
		WHERE crs.`crstype_id` = '".CTYPETRAIT."' AND g.`scid`='$scid' 
		ORDER BY cri.position,cri.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function conducts($db,$dbg,$sy,$scid){	
	$dbo=PDBO;
	$bq = "g.*,";	
	$q = "SELECT 'Conduct' AS trait,
			g.scid AS scid,g.course_id, $bq  g.q5				
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id			
		WHERE crs.crstype_id 	= '".CTYPECONDUCT."' AND	g.scid 	= '$scid'; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function attendanceMonths($db,$level_id,$sy,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.05_attendance_months 
			WHERE 	`level_id` = '".$level_id."' 
				AND `sy` = '".$sy."' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */


function coursesLocked($db,$crid,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT crs.name AS course,cq.*,cq.is_finalized_q$qtr AS cqtr
		FROM {$dbg}.05_courses_quarters AS cq
			INNER JOIN {$dbg}.05_courses AS crs ON cq.course_id = crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.crid = '$crid' AND crs.`is_active` = '1';";
	$sth 	= $db->querysoc($q);
	$rows 	= $sth->fetchAll();
	$ar = buildArray($rows,'is_finalized_q'.$qtr);
	if(in_array('0',$ar)){ return false; 
	} else { return true; }

}	/* fxn */



function legends($db,$dbg,$ctype_id,$dept_id=2){
$dbo=PDBO;
$qrydept = "";
switch($dept_id){
	case 1:  $qrydept .= " `is_ps` = 1 "; break;
	case 2:  $qrydept .= " `is_gs` = 1 "; break;
	default: $qrydept .= " `is_hs` = 1 "; break;
}

$q = "SELECT * FROM {$dbg}.05_descriptions 
	WHERE `crstype_id` = '$ctype_id' AND {$qrydept}
	ORDER BY `grade_floor` DESC;";
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */


function classlist($db,$dbg,$sy,$crid,$order="c.name",$fields=NULL,$filters=NULL){
	$dbo=PDBO;
	$q = "SELECT ats.timein,ats.timeout,sum.*,sum.id AS sumid,cr.acid AS acid,
			c.is_male,$fields c.id AS scid,c.code AS student_code,c.name AS student,c.is_active,c.is_cleared,
			s.*,s.contact_id,sum.crid AS crid,s.prevcrid AS prevcrid,c.`sy`,sum.scid AS sumscid			
		FROM {$dbg}.`05_summaries` AS sum
			LEFT JOIN {$dbg}.05_students AS s ON sum.scid  = s.contact_id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid  = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON sum.scid  = p.contact_id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid 	 = cr.id
			LEFT JOIN {$dbg}.05_attendance_schemas AS ats ON c.attschema_id = ats.id
		WHERE sum.crid 	= '$crid' $filters ORDER BY $order ; ";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function countCridCourses($db,$crid,$dbg,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }

$q = "SELECT count(crs.id) AS numrows FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1' AND crs.`crstype_id` <> '".CTYPETRAIT."' $semester ;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */


function subjects($db,$crid,$dbg,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }
$q = "SELECT crs.id AS course_id,crs.name AS course,crs.label,crs.position
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid` = '$crid'  AND crs.`is_active`='1' AND crs.`is_displayed` 	= '1'  	
		AND crs.`crstype_id` <> '".CTYPETRAIT."' $semester ORDER BY crs.position,crs.id; ";
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */



