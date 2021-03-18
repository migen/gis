<?php


function getAllClassrooms($db,$dbg,$fields="id,code,name,level_id,section_id",$where=NULL,$order="section_id,level_id"){
	$dbo=PDBO;
	$brid=$_SESSION['brid'];
	$q=" SELECT $fields FROM {$dbg}.05_classrooms WHERE branch_id=$brid $where ORDER BY $order;";
	debug("classroomsFxn-getAllClassrooms: ".$q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function tmpClassrooms($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT cr.id,cr.name FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id
		WHERE s.code = 'TMP';	
	";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getClassroomsByLevel($db,$lid,$dbg=PDBG,$where=NULL){	
	/* 2 - get current level tmp classroom */
	$dbo=PDBO;
	$q = "
		SELECT cr.id AS crid,cr.name AS classroom,cr.id,cr.name,cr.acid AS acid,cr.level_id AS lvl,
			sec.`code`,sec.`id` AS sxn,c.name AS adviser
		FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		WHERE 
				cr.level_id = '".$lid."' $where;		
	";
	// pr($q);
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	return $rows;
}	/* fxn */


function getSectionsByLevel($db,$lvlid,$dbg=PDBG){	
	$dbo=PDBO;
	$q = " SELECT sxn.id,sxn.name FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		WHERE cr.level_id = '$lvlid'; ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	return $rows;
}	/* fxn */




/* from ctc & ntc */
function levelClassroomsByCrid($db,$crid,$dbg=PDBG){	
	/* 1 - get next level_id */
	$dbo=PDBO;
	$q = " SELECT level_id FROM {$dbg}.05_classrooms WHERE id = '$crid' ;	";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$level_id = $row['level_id'];

	/* 2 - get current level tmp classroom */
	$q = "
		SELECT cr.id AS crid,cr.name AS classroom,cr.id,cr.name,cr.acid AS acid,cr.level_id AS lvl	
		FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		WHERE cr.level_id = '$level_id' ORDER BY cr.level_id; ";
	// echo "fxn/classrooms - levelClassroomsByCrid "; pr($q);
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();

	return $rows;

}	/* fxn */


function getClassroomsButTmp($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT cr.id,cr.name
		FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		WHERE sxn.code <> 'TMP' ORDER BY cr.level_id; ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	return $rows;

}	/* fxn */


function in_remarksLevel($classroom){
	$lvlid = $classroom['level_id'];
	$rl = $_SESSION['settings']['remarks_levels'];
	$rlr = explode(',',$rl);
	$in_rl = (in_array($lvlid,$rlr))? true:false;
	return $in_rl;
}	/* fxn */




function getCoursesByClassroom($crid,$db,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT crs.*,ct.name AS ctype,c.id AS teacher,crs.id AS crs,sub.name AS subject
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_crstypes` AS ct ON crs.crstype_id=ct.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	WHERE crs.`crid`='$crid' ORDER BY sub.name; ";
$sth=$db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */



