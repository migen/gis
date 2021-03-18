<?php

function matrixClassrooms($db,$dbg){
$dbo=PDBO;
$q = "
	SELECT 
		c.name AS adviser,c.id AS ucid,c.account,ctp.ctp,
		crs.id AS trait_id,
		cr.*,cr.id AS crid,cr.name AS classroom,
		l.name AS level,sxn.name AS section
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS crs ON crs.crid = cr.id
	WHERE cr.section_id > '2'
	ORDER BY cr.level_id,sxn.name;
";
debug($q);
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function updateGradesCtype($db,$dbg,$crid){
	$dbo=PDBO;
	$q=" UPDATE {$dbg}.50_grades AS a
		INNER JOIN (
			SELECT id AS course_id,crstype_id FROM {$dbg}.05_courses WHERE crid='$crid'
		) AS b ON a.course_id=b.course_id
		SET a.crstype_id=b.crstype_id; ";
	// pr($q);exit;
	$db->query($q);

}	/* fxn */



function matrixClassyear($db,$dbg,$sy,$crid,$order,$fields=NULL){	
	$dbo=PDBO;
	$q = " SELECT $crid AS crid,$crid AS crid,$fields			
			c.id AS scid,c.code AS student_code,c.name AS student,
			summ.id AS sumid,summ.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		WHERE summ.crid = '$crid' ORDER BY $order ;			
	";	
	echo "fxn/syncMatrixFxn matrixClassyear: "; pr($q);
	debug($q,"reportsFxn classyear");
	$_SESSION['q']="Reports Fxn - classyear() <br /> ".$q;
	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function matrixCourses($db,$dbg,$crid,$order="crs.position,crs.id "){	
$dbo=PDBO;
$q="
	SELECT 
		cr.id AS crid,cr.name AS classroom,crs.id AS course_id,crs.name AS course
	FROM {$dbg}.`05_classrooms` AS cr
	LEFT JOIN {$dbg}.`05_courses` AS crs ON crs.crid=cr.id
	WHERE crs.crid='$crid' AND crs.is_active=1 AND crs.crstype_id <> '".CTYPETRAIT."';
";	
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


