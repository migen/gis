<?php

function getUnicourses($db,$dbg,$where){
	$dbo=PDBO;
	$q="SELECT c.id AS crs,c.name AS course,c.*,cr.name AS classroom,cr.code AS crcode,
			t.name AS teacher,s.code AS subcode,s.name AS subject,
			GROUP_CONCAT(ps.name ORDER BY ps.name SEPARATOR ', ') AS prerequisite_list			
		FROM {$dbg}.01_courses AS c
		LEFT JOIN {$dbg}.01_classrooms AS cr ON c.crid=cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS s ON c.subject_id=s.id
		LEFT JOIN {$dbg}.01_prerequisites AS pr ON pr.subject_id=s.id
		LEFT JOIN {$dbo}.`05_subjects` AS ps ON pr.parent_id = ps.id
		LEFT JOIN {$dbo}.`00_contacts` AS t ON c.tcid=t.id $where
		GROUP BY c.id ORDER BY cr.id,c.level_id,c.semester,s.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
} 	/* fxn */	



function getCridArray($db,$dbg,$major_id){	
	$q="SELECT id,name FROM {$dbg}.01_classrooms WHERE major_id='$major_id';";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$crid_array=buildArray($rows,"id");
	// pr($crid_array);
	return $crid_array;
		
	
}	/* fxn */

function getCrsArray($db,$dbg,$major_id,$subject_id){	
	$q="SELECT crs.id,crs.name FROM {$dbg}.01_courses AS crs
		INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
		WHERE cr.major_id='$major_id' AND crs.subject_id='$subject_id' ORDER BY crs.id;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$crs_array=buildArray($rows,"id");
	return $crs_array;
		
	
}	/* fxn */

function upnameCourses($db,$dbg){
	$q="UPDATE {$dbg}.01_courses AS crs
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id			
		SET crs.name=CONCAT(cr.code,'-',sub.code) WHERE crs.name IS NULL;";	
	$db->query($q);

}	/* fxn */