<?php


function getRatings($db,$type_id=1,$dept_id=2,$dbg=PDBG){
	$dbo=PDBO;
	$dept_id=($dept_id==5)? 2:$dept_id;
	$type=" crstype_id='$type_id' " ;		
	if ($dept_id == 2) 			$dept=" is_gs = '1' ";
		elseif ($dept_id == 3) 	$dept=" is_hs = '1' ";
		else 					$dept=" is_ps = '1' ";
					 				 
	$q = "SELECT id AS dgid,rating,grade_floor AS grade FROM {$dbg}.05_descriptions 
			WHERE $type and $dept ORDER BY grade_floor desc; ";		
	debug($q,"reports: getRatings");		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();			
}	/* fxn */


function summarizer($db,$dbg,$sy,$scid,$crid,$ctype=1,$agg=1,$filter=NULL,$limit=NULL,$electives=NULL){
	$dbo=PDBO;
	$cond=($ctype)? " AND ( crs.crstype_id = '$ctype' $electives )  " : null;
	$cond.=($agg)? " " : " AND (crs.is_aggregate = 0) ";
	$q =" SELECT g.`course_id` AS `course_id`,crs.`label` AS `course`,crs.`supsubject_id`,crs.`units`,
			c.`id` AS `contact_id`,c.`id` AS `student_id`,c.`name` AS `student`,c.`code` AS `student_code`,
			sum.`ave_q1`,sum.`ave_q2`,sum.`ave_q3`,sum.`ave_q4`,sum.`ave_q5`,			
			sub.`name` AS `subject`,g.`id` AS `gid`,g.*			
		FROM {$dbg}.`50_grades` AS `g`
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			INNER JOIN {$dbg}.`05_summaries` AS sum ON sum.`scid`  = g.`scid` 
		WHERE g.`scid`='$scid' AND crs.`crid`='$crid' AND crs.`is_active`=1 $cond $filter ORDER BY crs.`position`,crs.`id`;";
	debug($q,"reports: summarizer");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getClassroomConductCourseId($db,$crid,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT crs.id AS id,crs.id AS course_id
	FROM {$dbg}.05_courses AS crs INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
	WHERE crs.crid = '$crid' AND (crs.crstype_id='".CTYPETRAIT."' || crs.crstype_id = '".CTYPECONDUCT."') LIMIT 1;";
	debug($q,"reports: getClassroomConductCourseId");
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */


function mcr($db,$dbg,$scid,$sy,$filter=NULL,$electives=NULL){	
	$dbo=PDBO;
	$q = " SELECT c.id AS scid,c.code AS student_code,c.name AS student,crs.id AS course_id,
		crs.label AS course,crs.supsubject_id,crs.affects_ranking,g.q1,g.q2,g.q3,g.q4,g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,
			sub.code AS subject_code,sub.name AS subject
		FROM {$dbg}.`50_grades` AS `g` 		
			LEFT JOIN {$dbg}.05_courses AS `crs` ON g.`course_id` = crs.`id`
			LEFT JOIN {$dbo}.`00_contacts` AS c ON g.`scid` = c.`id`
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.`subject_id` = sub.`id`
			LEFT JOIN {$dbg}.`05_courses_quarters` AS cq ON cq.`course_id` = crs.`id`
		WHERE g.scid    = '$scid' AND ( crs.crstype_id  = '1' $electives	) 
			AND crs.is_active ='1' $filter ORDER BY crs.position,crs.id; ";
	debug($q,"reports: mcr");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* qcr	*/



function classyear($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active`='1' ":NULL;	
	$condlimit=isset($limit)? " LIMIT $limit ":NULL;
	
	$q = " SELECT $fields $crid AS crid,$crid AS crid,c.*,c.id AS scid,c.code AS student_code,c.name AS student,
			c.`sy`,sum.*,sum.id AS sumid,sum.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		INNER JOIN {$dbg}.05_summext AS sx ON sum.scid = sx.scid
		WHERE sum.crid='$crid' $is_male $filters ORDER BY $order $condlimit;";	
	debug($q,"reportsFxn classyear");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function classSummaries($db,$dbg,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active`='1' ":NULL;	
	$q = " SELECT $fields $crid AS crid,$crid AS crid,c.*,c.id AS scid,c.code AS student_code,c.name AS student,
			c.`sy`,sum.id AS sumid,sum.scid AS sumscid,sum.*,sx.*
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		INNER JOIN {$dbg}.05_summext AS sx ON sx.scid = c.id
		WHERE sum.crid 	= '$crid' $is_active $is_male $filters ORDER BY $order ;";	
	// pr($q);				
	debug($q,"reportsFxn classyear");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



function cridCourses($db,$dbg,$crid,$ctype=1,$agg=1,$filter=NULL,$electives=NULL,$limit=NULL,$is_active=1,$order="crs.position,crs.id "){
$dbo=PDBO;
$active = ($is_active)? " AND crs.is_active = '1' " : "";
$cond 	= ($ctype)? " AND ( crs.`crstype_id` = '$ctype' $electives )  " : null;
$cond  .= ($agg)? " " : " AND (crs.`is_aggregate` = '0') ";
$q = " SELECT crs.id AS crs,l.code AS level_code,sxn.code AS section_code,l.name AS level,sxn.name AS section,
		sub.code AS subject_code,sub.name AS subject,supsub.name As supsubject,
		teac.id AS tcid,teac.name AS teacher,teac.account AS tlogin,ctp.ctp AS tpass,
		cq.*,cty.name AS crstype,crs.id AS crsid,crs.id AS course_id,crs.name AS course,
		crs.code AS course_code,crs.*,sub.position AS subpos		
	FROM  {$dbg}.05_classrooms AS cr 	
		LEFT JOIN  {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN  {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id		
		LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid=cr.id
		LEFT JOIN  {$dbo}.`00_contacts` AS teac ON crs.tcid=teac.id
		LEFT JOIN  {$dbo}.`00_ctp` AS ctp ON crs.tcid=ctp.contact_id
		LEFT JOIN  {$dbo}.`05_crstypes` AS cty ON crs.crstype_id=cty.id		
		LEFT JOIN  {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id=crs.id
		LEFT JOIN  {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id=supsub.id				
	WHERE cr.`id`='$crid' $active $cond $filter
	ORDER BY $order $limit ; ";	
debug($q,"reports: cridCourses");
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function levelCourses($db,$dbg,$lvlid,$ctype=1,$agg=1,$filter=NULL,$electives=NULL,$limit=NULL,$is_active=1,$order="crs.position,crs.id "){
$dbo=PDBO;
$active = ($is_active)? " AND crs.is_active = '1' " : "";
$cond 	= ($ctype)? " AND ( crs.`crstype_id` = '$ctype' $electives )  " : null;
$cond  .= ($agg)? " " : " AND (crs.`is_aggregate` = '0') ";
$q = " SELECT sxn.name AS section,sub.code AS subject_code,sub.name AS subject,supsub.name As supsubject,
		teac.id AS tcid,teac.name AS teacher,teac.account AS tlogin,ctp.ctp AS tpass,
		cq.*,cty.name AS crstype,crs.id AS crsid,crs.id AS course_id,crs.name AS course,
		crs.code AS course_code,crs.*		
	FROM  {$dbg}.05_classrooms AS cr 	
		LEFT JOIN  {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
		LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid=cr.id
		LEFT JOIN  {$dbo}.`00_contacts` AS teac ON crs.tcid=teac.id
		LEFT JOIN  {$dbo}.`00_ctp` AS ctp ON crs.tcid=ctp.contact_id
		LEFT JOIN  {$dbo}.`05_crstypes` AS cty ON crs.crstype_id=cty.id		
		LEFT JOIN  {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN  {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id=supsub.id		
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id=crs.id
	WHERE cr.`level_id`='$lvlid' $active $cond $filter ORDER BY $order $limit ";	
debug($q,"reports: levelCourses");
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */




function countCridCourses($db,$crid,$dbg){
$dbo=PDBO;
$q = " SELECT count(crs.id) AS numrows FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid` 	= '$crid' AND crs.`is_active` = '1' AND crs.`is_displayed` = '1' AND crs.`crstype_id` <> '".CTYPETRAIT."' ; ";
debug($q,"reports: countCridCourses");
$sth = $db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */


function coursesLocked($db,$crid,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT crs.name AS course,cq.*,cq.is_finalized_q$qtr AS cqtr
		FROM {$dbg}.05_courses_quarters AS cq
			INNER JOIN {$dbg}.05_courses AS crs ON cq.course_id = crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.crid = '$crid' AND crs.`is_active` = '1'; ";
	debug($q,"reports: coursesLocked");
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$ar = buildArray($rows,'is_finalized_q'.$qtr);
	if(in_array('0',$ar)){ return false; 
	} else { return true; }

}	/* fxn */



function getLegends($db,$dbg,$ctype_id,$dept_id=2){
$dbo=PDBO;
$qrydept = "";
switch($dept_id){
	case 1:  $qrydept .=" `is_ps`=1 ";break;
	case 2:  $qrydept .=" `is_gs`=1 ";break;
	default: $qrydept .=" `is_hs`=1 ";break;
}
$q = "SELECT * FROM {$dbg}.05_descriptions WHERE `crstype_id` = '$ctype_id'
		AND {$qrydept} ORDER BY `grade_floor` DESC;";
debug($q,"reports: getLegends");
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */


function subjects($db,$crid,$dbg,$sem=1){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }

$q = " SELECT crs.id AS course_id,crs.name AS course,crs.label,crs.position,crs.subject_id
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid` 	= '$crid' AND crs.`is_active` = '1'  AND crs.`is_displayed` = '1'  
		AND crs.`crstype_id` <> '".CTYPETRAIT."' $semester ORDER BY crs.position,crs.id; ";
debug($q,"reports: subjects");
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;

}	/* fxn */



function allsubjects($db,$crid,$dbg,$sem=1){
$dbo=PDBO;
$semester = NULL;
if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }
$q = "SELECT crs.id AS course_id,crs.name AS course,crs.label,crs.position,crs.subject_id
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid` = '$crid' AND crs.`is_active` = '1'  $semester ORDER BY crs.position,crs.id;";
debug($q,"reports: allsubjects");
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;



}	/* fxn */
