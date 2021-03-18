<?php

function getUnicourseDetails($db,$crs,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT sub.id AS sub,sub.code AS subcode,sub.name AS subject,
			t.id AS tcid,t.code AS teacher_code,t.name AS teacher,
			cr.*,cr.name AS classroom,sxn.name AS section,
			m.code AS major_code,m.name AS major,
			crs.*,crs.id AS crs,crs.id AS course_id	
		FROM   {$dbg}.01_courses AS crs
			LEFT JOIN  {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
			LEFT JOIN {$dbg}.01_sections AS sxn ON cr.section_id=sxn.id
			LEFT JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
			LEFT JOIN {$dbo}.`00_contacts` AS t ON crs.tcid=t.id
		WHERE crs.id =  '$crs' LIMIT 1; ";
	debug($q,"Details: getUnicourseDetails ");
	$sth = $db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */



function getUnisubjectDetails($db,$subject_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT * FROM {$dbo}.`05_subjects`  WHERE `id`='$subject_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */



function getSectionDetails($db,$sxn,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbg}.01_sections WHERE `id`='$sxn' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

function getTeacherDetails($db,$tcid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE `id` = '$tcid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function getClassroomDetails($db,$crid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT sxn.name AS section,sxn.code AS sxncode,cr.*,cr.id AS crid,cr.name AS classroom,m.name AS major,m.code AS major_code
			FROM   {$dbg}.01_classrooms AS cr 
			INNER JOIN {$dbg}.01_sections AS sxn ON cr.section_id=sxn.id
			INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
			WHERE cr.id = '$crid' LIMIT 1; ";
			debug($q);
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

