<?php



function getCourseData($db,$dbg,$crs){
	$dbo=PDBO;
	$q=" SELECT * FROM {$dbg}.05_courses WHERE id='$crs' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */
	
	
	
function getCourseInfo($db,$dbg,$crs){	
	$dbo=PDBO;
	$q=" SELECT crs.id AS `crs`,crs.*,t.name AS teacher,cr.name AS classroom,
			l.name AS level,s.name AS section,n.name AS strand
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`00_contacts` AS t ON crs.tcid=t.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		LEFT JOIN {$dbg}.05_nums AS n ON cr.num=n.id
	WHERE crs.id='$crs' LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */
	