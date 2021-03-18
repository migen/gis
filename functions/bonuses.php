<?php


function getClassroomConductCourse($db,$dbg,$crid,$ctype=CTYPETRAIT){
$dbo=PDBO;
$q = "SELECT crs.id AS course_id,crs.id AS conduct_id,crs.name AS conduct,crs.subject_id,crs.crstype_id
	FROM {$dbg}.05_classrooms AS cr LEFT JOIN {$dbg}.05_courses AS crs ON crs.crid = cr.id
	WHERE crs.crid = '$crid' AND	crs.crstype_id = '$ctype' LIMIT 1;";
debug($q);
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter=NULL,$sem=0){
$dbo=PDBO;
$condsem=($sem>0)? "AND (crs.semester=$sem || crs.semester=0 )":NULL;
$q = "SELECT sub.code AS subject_code,sub.name AS subject,
		supsub.name As supsubject,teac.id AS tcid,teac.name AS teacher,teac.account AS tlogin,
		ctp.ctp AS tpass,cq.*,cty.name AS crstype,	
		crs.id AS crsid,crs.id AS course_id,crs.name AS course,
		crs.code AS course_code,crs.* $fields		
	FROM  {$dbg}.05_classrooms AS cr 	
		LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid 	   	=cr.id
		LEFT JOIN  {$dbo}.`00_contacts` AS teac ON crs.tcid   	=teac.id
		LEFT JOIN  {$dbo}.`00_ctp` AS ctp ON crs.tcid=ctp.contact_id
		LEFT JOIN  {$dbo}.`05_crstypes` AS cty ON crs.crstype_id =cty.id		
		LEFT JOIN  {$dbo}.`05_subjects` AS sub ON crs.subject_id 		=sub.id
		LEFT JOIN  {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id 	=supsub.id		
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id =crs.id
	WHERE 	cr.id='$crid' AND crs.crstype_id<>'".CTYPETRAIT."' AND crs.`is_active`=1 $filter $condsem
	ORDER by crs.`position`,crs.`id`; ";
	debug($q,"bonuses: matrixSubjects");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();


}


function matrixGrades($db,$dbg,$scid,$filter=NULL,$sem=0){	
	$dbo=PDBO;
	$condsem=($sem>0)? "AND (crs.semester=$sem || crs.semester=0 )":NULL;
	$q = "SELECT sub.name AS course,sub.code AS subject_code,crs.name AS course,crs.label,crs.code AS course_code,crs.on_reports,
			g.id AS gid,g.course_id,g.id AS grade_id,g.*,crs.is_num
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.50_grades AS g ON g.scid = c.id
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		WHERE g.scid =  '$scid' AND crs.crstype_id<>'".CTYPETRAIT."' AND crs.is_active = 1
			$filter $condsem ORDER by crs.position,crs.id; ";			
	// debug($q,"bonuses: matrixGrades");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



