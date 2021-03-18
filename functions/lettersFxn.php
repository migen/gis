<?php



function getTraitsByLevel($db,$qtr,$dbg,$lvl,$fields){
$dbo=PDBO;
$q="
	SELECT $fields
	FROM {$dbg}.50_grades AS g
	LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=g.scid
	LEFT JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
	LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id
	LEFT JOIN {$dbo}.`05_criteria` AS cri ON cri.id=g.criteria_id
	WHERE crs.crstype_id=2 AND l.id='$lvl'	AND cr.section_id>2 AND c.is_active=1
	ORDER BY cr.name,c.name,cri.id ;";
debug($q,"lettersFxn: getTraitsByLevel");
$sth=$db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */

function lockTraitsBylevel($db,$qtr,$lvl){
	$dbo=PDBO;
	$dbg=PDBG;	
	$q="SELECT crs.id AS crs,crs.name
	FROM {$dbg}.05_courses AS crs 
	INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
	WHERE cr.level_id='$lvl' AND crs.crstype_id=2; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();

	$q="";
	foreach($rows AS $row){
		$crs=$row['crs'];
		$q.="UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}`=1 WHERE `course_id`='$crs' LIMIT 1; ";
	}
	$db->query($q);
	
}	/* fxn */

