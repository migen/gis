<?php


function subcourses($db,$subject_id,$dbg=PDBG){	
	$dbo=PDBO;
	$q = "SELECT crs.*,cr.name AS classroom FROM {$dbg}.05_courses AS crs LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.subject_id = '$subject_id' ORDER BY crs.crid; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll(); 				
}	/* fxn */



function getSubjects($db,$dbg=PDBG,$where=NULL){
	$dbo=PDBO;
	$q=" SELECT *,id AS sub,name AS subject FROM {$dbo}.`05_subjects` WHERE 1=1 $where ORDER BY name; ";
	$_SESSION['q']="Subjects Fxn - getSubjects() $q ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function getLevelSubjects($db,$dbg=PDBG,$lvl){
	$dbo=PDBO;
	$q="SELECT sub.id AS subject_id,sub.id AS sub,sub.name AS subject,sub.position,sub.*,crs.label
		FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		WHERE cr.level_id = '$lvl' GROUP BY sub.id ORDER BY sub.name; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function getLevelCourses($db,$dbg=PDBG,$lvl){
	$dbo=PDBO;
	$q=" SELECT sub.id AS subject_id,sub.id AS sub,
			crs.code AS crscode,sub.name AS subcode,
			crs.name AS crsname,sub.name AS subname,
			crs.label AS crslabel,sub.label AS sublabel,
			crs.crstype_id AS crsctype,sub.crstype_id AS subctype,
			crs.with_scores AS crsws,sub.with_scores AS subws,
			crs.is_kpup AS crskpup,sub.is_kpup AS subkpup,
			crs.on_reports AS crsrpts,sub.on_reports AS subrpts,
			crs.is_num AS crsnum,sub.is_num AS subnum,
			crs.is_displayed AS crsdisp,sub.in_genave AS subdisp,
			crs.in_genave AS crsinga,sub.in_genave AS subinga,
			crs.supsubject_id AS crssupsub,sub.parent_id AS subprid,
			crs.is_aggregate AS crsaggre,sub.is_aggregate AS subaggre,
			crs.position AS crspos,sub.position AS subpos,
			crs.indent AS crsindent,sub.indent AS subindent,
			crs.semester AS crssem,sub.semester AS subsem,
			crs.course_weight AS crswt,sub.weight AS subwt
		FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		WHERE cr.level_id = '$lvl' GROUP BY sub.id ORDER BY sub.name; ";
	$_SESSION['q']="Subjects Fxn - getLevelCourses() ".$q;	
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function propagateLevelCoursesQuery($lvl,$post,$dbg=PDBG){
$dbo=PDBO;
$sub=$post['subject_id'];
$crstype_id=$post['crstype_id'];
$supsubject_id=$post['supsubject_id'];
$code=$post['code'];
$label=$post['label'];
$is_num=$post['is_num'];
// $is_kpup=$post['is_kpup'];
$on_reports=$post['on_reports'];
$with_scores=$post['with_scores'];
$is_aggregate=$post['is_aggregate'];
$position=$post['position'];
$indent=$post['indent'];
$semester=$post['semester'];
$weight=$post['weight'];
$is_displayed=$post['is_displayed'];
$in_genave=$post['in_genave'];

$q="UPDATE {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
	SET crs.`code`='$code',crs.`label`='$label',crs.`with_scores`='$with_scores',crs.`crstype_id`='$crstype_id',
		crs.`supsubject_id`='$supsubject_id',crs.`course_weight`='$weight',crs.`is_aggregate`='$is_aggregate',
		crs.`position`='$position',crs.`indent`='$indent',crs.`semester`='$semester',crs.`in_genave`='$in_genave',
		crs.`on_reports`='$on_reports',crs.`is_num`='$is_num',crs.`is_displayed`='$is_displayed'
	WHERE cr.level_id='$lvl' AND crs.subject_id='$sub';	";
return $q;


}	/* fxn */


function createLevelCoursesQuery($crids,$sub,$dbg=PDBG){	
	$dbo=PDBO;
	$q=" INSERT IGNORE INTO {$dbg}.05_courses(`crid`,`subject_id`) VALUES ";
	foreach($crids AS $crid){ $q.="('$crid','$sub'),"; }	
	$q=rtrim($q,","); $q.=";";
	return $q;
}	/* fxn */
