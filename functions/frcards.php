<?php




function checkRcardSchedule($db,$scid){
	$dbg=PDBG;$dbo=PDBO;
	$q="SELECT summ.crid,rs.is_open
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=summ.crid
		WHERE summ.scid=$scid LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$allowed = ($row['is_open'])? true:false;
	return $allowed;
		
	
}	/* fxn */



function getMonthsCovered($rows,$qtr){
	$qtr_mos = [];
	foreach($rows AS $row){
		if($row['quarter']<1) continue;
		if($row['quarter']<=$qtr){
			array_push($qtr_mos,$row['code']);
		}
	}
	return $qtr_mos;
	
}	/* fxn */


function getStudentEnrollment($db,$sy,$scid){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.05_enrollments WHERE sy=$sy AND scid=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */


function classyear($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;
	$condlimit=isset($limit)? " LIMIT $limit ":NULL;
	
	if(isset($_GET['sch'])){
		$sch=$_GET['sch'];
		$dbo=VCPREFIX."dbone_{$sch}";
	} else { $dbo=PDBO; }
		
	$q = "SELECT '$crid' AS crid,c.*,$fields c.id AS scid,c.code AS student_code,c.name AS student,
		c.`sy`,sum.scid AS sumscid,cr.level_id
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN `{$dbo}`.`00_profiles` AS `p` ON p.`contact_id` = c.`id`
			LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`
			LEFT JOIN {$dbg}.`05_classrooms` AS `cr` ON sum.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS `l` ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS `s` ON cr.section_id = s.id
		WHERE sum.`crid`='$crid' $is_active $is_male $filters ORDER BY $order $condlimit; ";	
	if(isset($_GET['debug'])){ pr($q); }
	debug($q,"frcards: classyear");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function student($db,$dbg,$sy,$scid,$fields=NULL){
	$dbo=PDBO;
	$q = "
			SELECT 		
				c.`id` AS `scid`,c.`code` AS `student_code`,c.`name` AS `student`,c.crid AS scrid,	
				sum.`crid` AS `crid`,sum.`id` AS `sumid`,sum.`crid` AS `crid`,c.`sy` AS sy,
				sum.`acid` AS acid,sum.ave_q1 AS ag1,sum.ave_q2 AS ag2,sum.ave_q3 AS ag3,sum.ave_q4 AS ag4,sum.ave_q5 AS agf,
				sum.ave_dg1 AS adg1,sum.ave_dg2 AS adg2,sum.ave_dg3 AS adg3,sum.ave_dg4 AS adg4,sum.ave_dg4 AS adgf,			
				sum.conduct_q1 AS cg1,sum.conduct_q2 AS cg2,sum.conduct_q3 AS cg3,sum.conduct_q4 AS cg4,sum.conduct_q5 AS cgf,
				sum.conduct_dg1 AS cdg1,sum.conduct_dg2 AS cdg2,sum.conduct_dg3 AS cdg3,sum.conduct_dg4 AS cdg4,sum.conduct_dg5 AS cdgf,	
				p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,						
				cr.*,cr.name AS classroom,			
				l.*,l.name AS level,
				sec.name AS section,
				sum.*,p.*,s.*,c.*,sum.crid AS crid
				$fields					
			FROM {$dbo}.`00_contacts` AS `c` 		
				LEFT JOIN {$dbo}.`00_profiles` AS `p` ON p.`contact_id` = c.id
				LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`
				LEFT JOIN {$dbg}.05_students AS `s` ON s.`contact_id` = c.`id`
				LEFT JOIN {$dbg}.05_classrooms AS `cr` ON sum.`crid` = cr.`id`
				LEFT JOIN {$dbo}.`05_levels` AS `l` ON cr.`level_id` = l.`id`
				LEFT JOIN {$dbo}.`05_sections` AS `sec` ON cr.`section_id` = sec.`id`
			WHERE c.`id` 	= '$scid' 
			LIMIT 1;		
	";	
	if(isset($_GET['debug'])){ pr($q); }
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row;


}	/* fxn */


function getClassroomDetails($db,$crid,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT l.*,d.name AS department,l.name AS level,l.code AS lvlcode,
		sec.name AS section,sec.code AS sxncode,c.account AS login,c.code AS teacher_code,c.code AS adviser_code,
		c.name AS adviser,c.code AS adviser_code,cr.*,cr.id AS crid,cr.name AS classroom,l.department_id,aq.*		
	FROM   {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		INNER JOIN {$dbo}.`05_departments` AS d ON l.department_id = d.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid = cr.id
	WHERE cr.id = '$crid' LIMIT 1; ";
debug($q,"frcards, getClassroomDetails");
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */




/* attd,traits,grades,conduct,conducts,psmapehs */
function summary($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;
$q = " SELECT summ.id AS sumid,summ.*,l.name AS promlevel
	FROM {$dbg}.`05_summaries` AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id 
		LEFT JOIN {$dbo}.`05_levels` AS l ON summ.promlvl = l.id 
	WHERE summ.`scid` = '$scid' LIMIT 1;";
// pr($q);
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



/* rcard-chinese */
function sumo($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;

$q = "SELECT sumo.id AS sumoscid,sumo.*
	FROM {$dbg}.`summaries_other` AS sumo
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sumo.scid = c.id 
	WHERE sumo.`scid` = '$scid' ;";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function attendance($db,$dbg,$sy,$scid){
$dbo=PDBO;
$q = "SELECT att.*,att.id AS attid,c.id AS scid,c.code AS student_code,c.name AS student 
	FROM {$dbg}.05_attendance as att INNER JOIN {$dbo}.`00_contacts` AS c ON att.scid 	= c.id	 			
	WHERE att.`scid`  = '$scid'; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function grades($db,$dbg,$sy,$crid,$scid,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }

$q = "SELECT tcon.id AS tcid,tcon.code AS teacher_code,tcon.name AS teacher,
		crs.label AS subject,crs.crid,crs.*,g.`id` AS `gid`,g.*		
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.50_grades AS g ON g.course_id = crs.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		LEFT JOIN {$dbo}.`00_contacts` AS tcon ON crs.tcid = tcon.id		
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1' 
		AND crs.`crstype_id` <> ".CTYPETRAIT." AND g.`scid`='$scid' $semester
	ORDER BY crs.position,crs.id ; ";
debug("frcards-grades: $q");
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function traits($db,$dbg,$sy,$scid){
	$dbo=PDBO;
	$bq = " g.q1,g.q2,g.q3,g.q4,";
	$q = "SELECT cri.name AS trait,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id, 
			$bq g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
		WHERE crs.`crstype_id` = '".CTYPETRAIT."' AND	g.`scid` 	= '$scid' 
		ORDER BY cri.position,cri.id; ";
	debug($q,"frcards: traits ");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function traitsSemOK($db,$dbg,$sy,$scid,$o12=0){
$dbo=PDBO;
/* $o12 */
	$bq = " g.q1,g.q2,g.q3,g.q4,";
	$q="SELECT ";
	$q.=" cri.name AS trait,cri.critype_id,ct.name AS critype,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id, 
			$bq g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
			LEFT JOIN {$dbo}.`05_critypes` AS `ct` ON cri.`critype_id` = ct.`id` ";		
	if($o12){
		$q.=" INNER JOIN {$dbg}.05_classrooms AS `cr` ON crs.`crid` = cr.`id`  
			INNER JOIN {$dbg}.05_components AS `com` ON (com.`level_id` = cr.`level_id` && com.`criteria_id` = cri.`id`) ";	
	} 
		
	$q.=" WHERE crs.`crstype_id`='".CTYPETRAIT."' AND g.`scid`='$scid' ";
	if($o12) $q.= " AND	(com.`semester` = '0' || com.`semester` = '$o12') ";	
	$q.=" ORDER BY ct.id,cri.position,cri.id; ";
	pr($q);
	debug($q);
	// $_SESSION['q']=$q;
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function traitsSem($db,$dbg,$sy,$scid,$o12=0){
$dbo=PDBO;
/* $o12 */
	$bq = " g.q1,g.q2,g.q3,g.q4,g.q5,g.q6,";
	$q="SELECT ";
	$q.=" cri.name AS trait,cri.critype_id,ct.name AS critype,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id, 
			$bq g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,g.dg6
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`			
			LEFT JOIN {$dbo}.`05_critypes` AS `ct` ON cri.`critype_id` = ct.`id` ";		
		$q.=" INNER JOIN {$dbg}.05_classrooms AS `cr` ON crs.`crid` = cr.`id`  
			INNER JOIN {$dbg}.05_components AS `com` ON (com.`level_id` = cr.`level_id` && com.`criteria_id` = cri.`id`) ";	
		
	$q.=" WHERE crs.`crstype_id`='".CTYPETRAIT."' AND g.`scid`='$scid' ";
	if($o12) $q.= " AND	(com.`semester` = '0' || com.`semester` = '$o12') ";	
	$q.=" ORDER BY ct.id,cri.position,cri.id; ";
	debug($q);
	// $_SESSION['q']=$q;
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function conducts($db,$dbg,$sy,$scid){	
	$dbo=PDBO;
	$bq = "g.*,";	
	$q = "SELECT 'Conduct' AS trait,g.scid AS scid,g.course_id,$bq g.q5				
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id			
		WHERE crs.crstype_id 	= '".CTYPECONDUCT."' AND	g.scid 	= '$scid'; ";
	// pr($q);
	$sth = $db->querysoc($q); 
	return $sth->fetchAll();
	
}	/* fxn */



function attendanceMonths($db,$level_id,$sy,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.05_attendance_months 
			WHERE 	`level_id` = '".$level_id."' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */



function coursesLocked($db,$crid,$qtr,$dbg=PDBG,$debug=false){
	$dbo=PDBO;
	$q = "SELECT crs.name AS course,cq.*,cq.is_finalized_q$qtr AS cqtr
		FROM {$dbg}.05_courses_quarters AS cq
			INNER JOIN {$dbg}.05_courses AS crs ON cq.course_id = crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.crid = '$crid' AND crs.`is_active` = '1'; ";
	$sth 	= $db->querysoc($q);
	$rows 	= $sth->fetchAll();
	$ar = buildArray($rows,'is_finalized_q'.$qtr);
	
	if($debug or isset($_GET['debug'])){ pr("frcards - coursesLocked / submissions: "); pr($q); pr($ar); }

	if(in_array('0',$ar)){ 
		return false; 
	} else { 
		return true; 
	}

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
	WHERE `crstype_id`=$ctype_id AND {$qrydept}
	ORDER BY `grade_floor` DESC; ;";
debug("frcards-legend:".$q);
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */



function countCridCourses($db,$crid,$dbg,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }

$q = "SELECT count(crs.id) AS numrows
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1' AND crs.`crstype_id` <> '".CTYPETRAIT."' $semester ;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
debug("frcards-countCridCourses: ".$q);
return $row['numrows'];


}	/* fxn */



function subjects($db,$crid,$dbg,$sem=0){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }


$q = "SELECT crs.id AS course_id,crs.name AS course,crs.label,crs.position
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1'  	
		AND crs.`crstype_id`<>'".CTYPETRAIT."' $semester ORDER BY crs.position,crs.id; ";
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */


function numtraits($db,$crid,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT count(com.id) AS count 
		FROM {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id=cri.id
			INNER JOIN {$dbo}.`05_levels` AS l ON com.level_id=l.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON cr.level_id=l.id
		WHERE cr.id='$crid' AND cri.crstype_id='".CTYPETRAIT."'; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$count=$row['count'];	
	return $count;

}	/* fxn */



function numlg($db,$crid,$dbg=PDBG){	/* letter grades crs.is_num=0 */
	$dbo=PDBO;
	$q="SELECT count(crs.id) AS count FROM {$dbg}.05_courses AS crs
		WHERE crs.crid='$crid' AND crs.crstype_id='".CTYPEACAD."' AND crs.is_num<>1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$count=$row['count'];		
	return $count;

}	/* fxn */




