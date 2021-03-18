<?php

function getCourseByClassroom($db,$dbg,$crid,$ctype){
$dbg=&$dbg;
$dbo=PDBO;
$q = " 
	SELECT 
		crs.id AS course_id,crs.name AS course,crs.*,
		cty.is_acad,cty.is_trait,cty.is_club,cty.is_psmapeh,cty.is_conduct,cty.is_cocurr,cty.is_elective,
		sub.id AS subject_id,sub.code AS subject_code,sub.name AS subject,
		tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,
		sub.id AS subject_id,sub.code AS subject_code,sub.name AS subject,
		supsub.name AS subsubject,
		cr.level_id,cr.section_id,l.name AS level,sec.name AS section,
		l.department_id,l.is_k12,l.is_ps,l.is_gs,l.is_hs,l.with_conduct_dg,
		cq.is_finalized_q1,cq.is_finalized_q2,cq.is_finalized_q3,cq.is_finalized_q4  			
	FROM {$dbg}.05_courses AS crs 
		LEFT JOIN  {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		LEFT JOIN {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id = supsub.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
		LEFT JOIN {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id	
	WHERE 
			crs.`crid` 	 = '$crid' 
		AND	crs.`crstype_id` = '$ctype'
	LIMIT 1;
";

$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */
