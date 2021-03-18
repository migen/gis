<?php


function getCrList($db,$dbg){
	$brid=isset($_GET['brid'])? $_GET['brid']:$_SESSION['brid'];
	$where=isset($_GET['all'])? NULL:"WHERE cr.branch_id=$brid"; 
	$dbo=PDBO;
	
	$q="
		SELECT
			cr.*,cr.id AS crid,l.name AS level,s.name AS section,cr.name AS classroom,cr.code AS crcode,
			count(summ.crid) AS num_students,c.name AS adviser
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 		
		$where GROUP BY cr.id ORDER BY l.id; ";
	debug($q);
	$sth=$db->querysoc($q);
	$d['rows']=$sth->fetchAll();
	$d['count']=$sth->rowCount();
	return $d;
		
}	/* fxn */


function getClassroomData($db,$dbg,$crid){
	$dbo=PDBO;
	$q=" SELECT * FROM {$dbg}.05_classrooms WHERE id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */
	
	
	
function getClassroomInfo($db,$dbg,$crid){	
	$dbo=PDBO;
	$q=" SELECT cr.*,
			l.name AS level,s.name AS section,m.name AS major,	
			d.name AS department,sd.name AS subdepartment,t.name AS adviser
		FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS t ON cr.acid=t.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		LEFT JOIN {$dbo}.`05_majors` AS m ON cr.major_id=m.id
		LEFT JOIN {$dbo}.`05_departments` AS d ON l.department_id=d.id
		LEFT JOIN {$dbo}.`05_subdepts` AS sd ON l.subdepartment_id=sd.id		
	WHERE cr.id='$crid' LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */
	