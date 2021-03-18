<?php


function getSubjectDetails($db,$subject_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT sub.* FROM {$dbo}.`05_subjects` AS sub 
		WHERE sub.`id` = '$subject_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

	
function getLevelDetails($db,$level_id,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT l.*,l.id AS level_id,l.code AS level_code,l.name AS level
	FROM {$dbo}.`05_levels` AS l WHERE l.`id` = '$level_id' LIMIT 1; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function getSectionDetails($db,$sid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbo}.`05_sections` WHERE `id` = '$sid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

function getTeacherDetails($db,$tcid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT id AS tcid,name,code AS teacher_code FROM {$dbo}.`00_contacts` WHERE `id` = '$tcid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function getClassroomDetails($db,$crid,$dbg=PDBG,$ctp=false){
$dbo=PDBO;
$q = "SELECT aq.*,l.*,d.name AS department,l.id AS lvl,l.name AS level,l.code AS lvlcode,sec.name AS section,sec.code AS sxncode,c.account,
		c.account AS login,c.code AS teacher_code,c.code AS adviser_code,c.name AS adviser,c.code AS adviser_code,
		cr.*,cr.id AS crid,cr.name AS classroom,l.department_id	";
if($ctp){ $q.=" ,ctp.ctp "; }				
$q.="	FROM   {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		LEFT JOIN {$dbo}.`05_departments` AS d ON l.department_id = d.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid = cr.id ";
if($ctp){ $q.=" LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id "; }				
$q.=" WHERE cr.id = '$crid' LIMIT 1; ";
// if(isset($_GET['debug'])){ echo "Fxn details > Classroom Details: "; pr($q); }
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function getSimpleClassroomDetails($db,$crid,$dbg=PDBG,$ctp=false){
$dbo=PDBO;
$q="SELECT 
		l.id AS lvl,l.name AS level,l.code AS lvlcode,sec.name AS section,sec.code AS sxncode,c.account,
		c.account AS login,c.code AS teacher_code,c.code AS adviser_code,c.name AS adviser,c.code AS adviser_code,
		cr.*,cr.id AS crid,cr.name AS classroom,l.department_id	
	FROM   {$dbg}.05_classrooms AS cr 
	INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
	INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
	LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id 
	WHERE cr.id=$crid LIMIT 1; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */




/* if(l.is_k12 = 1 AND l.is_ps = 0,1,0) AS is_kpup  */	
function getCourseDetails($db,$course_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT l.*,cq.*,cty.*,cty.name AS crstype,sub.id AS subject_id,sub.code AS subject_code,sub.name AS subject,sub.decimal,
			tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,supsub.name AS subsubject,
			cr.level_id,cr.section_id,l.name AS level,sec.name AS section,
			crs.*,crs.id AS crsid,crs.id AS course_id,crs.crstype_id AS ctyid,crs.crid AS crid			
		FROM   {$dbg}.05_courses AS crs
			LEFT JOIN  {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			LEFT JOIN {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id = supsub.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id
			LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
			LEFT JOIN {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id
		WHERE crs.id =  '$course_id' LIMIT 1; ";
	debug($q,"Details: getCourseDetails ");
	$sth = $db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */

