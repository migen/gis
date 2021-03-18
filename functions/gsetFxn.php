<?php

function insertClassroomIfNotExists($db,$dbg,$lvl,$sxn){
	$dbo=PDBO;
	$r="SELECT id FROM {$dbg}.05_classrooms WHERE `level_id`='$lvl' AND  `section_id`='$sxn' LIMIT 1;  ";
	$sth=$db->querysoc($r);
	$row=$sth->fetch();
	$q="";
	if(!$row){ $q="INSERT INTO {$dbg}.05_classrooms(`level_id`,`section_id`) VALUES('$lvl','$sxn');"; }
	return $q;
}	/* fxn */


function renameClassrooms($db,$sy=PDBG){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_branches` AS br ON cr.branch_id=br.id
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
	";	
	if($_SESSION['settings']['has_branches']==1){
		$q.=" SET cr.name=CONCAT(br.`code`,'-',l.`code`,'-',s.`name`);";		
	} else {		
		$q.=" SET cr.name=CONCAT(l.`code`,'-',s.`name`);";		
	}
	return $q;
}	/* fxn */


function renameCourses($db,$sy=PDBG){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`00_branches` AS br ON cr.branch_id=br.id
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id ";	
	if($_SESSION['settings']['has_branches']==1){
		$q.=" SET crs.name=CONCAT(br.`code`,'-',l.`code`,'-',s.`code`,'-',sub.`code`),crs.label=sub.`name`;";		
	} else {		
		$q.=" SET crs.name=CONCAT(l.`code`,'-',s.`code`,'-',sub.`code`),crs.label=sub.`name`;";		
	}
	return $q;
}	/* fxn */


function renameCoursesByLevel($db,$lvl){
	$dbo=PDBO;$dbg=PDBG;		
	$q="UPDATE {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`00_branches` AS br ON cr.branch_id=br.id
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id ";	
	if($_SESSION['settings']['has_branches']==1){
		$q.=" SET crs.name=CONCAT(br.`code`,'-',l.`code`,'-',s.`code`,'-',sub.`code`),crs.label=sub.`name`;";		
	} else {		
		$q.=" SET crs.name=CONCAT(l.`code`,'-',s.`code`,'-',sub.`code`),crs.label=sub.`name`;";		
	}
	$q.=" WHERE cr.`level_id`=$lvl;";		
	$db->query($q);

}	/* fxn */

function initClassrooms($db,$sy=DBYR){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT * FROM {$dbo}.05_levels ORDER BY id; ";
	$sth=$db->querysoc($q);
	$levels=$sth->fetchAll();
	$brid=$_SESSION['brid'];
	// 1-TMP, 2-OUT
	$q="INSERT INTO {$dbg}.05_classrooms(branch_id,level_id,section_id)VALUES";	
	foreach($levels AS $level){
		$lvl=$level['id'];
		$q.="($brid,$lvl,1),($brid,$lvl,2),";		
	}
	$q=rtrim($q,",");$q.=";";
	$sth=$db->query($q);
	debug($q);
	echo ($sth)? "Success":"Fail";
	
}	/* fxn */