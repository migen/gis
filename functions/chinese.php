<?php


function getChineseCourse($db,$crid,$dbg=PDBG){	
	$dbo=PDBO;
	$q = "SELECT IF(sub.`code` = 'CN2', 2, 0) as sem2,
			cr.id AS crid,cr.name AS classroom,crs.id AS crsid,sub.id AS subid	
		FROM {$dbg}.05_classrooms AS cr 
			LEFT JOIN {$dbg}.05_courses AS crs ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		WHERE (sub.code = 'CN' || sub.code = 'CN2') AND crs.is_aggregate = '1' AND crs.crid='$crid'
		ORDER BY cr.level_id,cr.section_id;";
	$sth = $db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */