<?php



function submissionCourses($db,$dbg,$crid,$cond=null){
	$dbo=PDBO;
	$q = "
		SELECT 
			cq.course_id,crs.crstype_id,
			c.id AS tcid,c.code,c.account,c.name AS teacher,		
			ctp.ctp,
			c.name AS teacher,		
			crs.tcid,crs.is_aggregate,crs.course_weight AS weight,crs.supsubject_id,crs.label,						
			sub.id AS subject_id,sub.name AS subject,sub.code AS subject_code,
			cty.is_acad,
			cq.*,
			'1' AS complete
		FROM {$dbg}.05_courses_quarters AS cq
			LEFT JOIN {$dbg}.05_courses AS crs ON cq.course_id = crs.id
			LEFT JOIN {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		WHERE 
			crs.crid = '$crid'
			AND crs.is_active = '1' $cond
		ORDER BY crs.position	
	";
	$_SESSION['q']=$q;
	// pr($q);
	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */

