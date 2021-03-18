<?php

function getFoundationCourses($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT crs.code AS crscode,crs.id AS crs,crs.name AS course,crs.semester AS sem,fdn.name AS foundation,sub.fdntype_id
		FROM {$dbg}.05_courses AS crs 
		INNER JOIN {$dbo}.`05_subjects` AS sub ON sub.id=crs.subject_id
		LEFT JOIN {$dbg}.05_fdntypes AS fdn ON sub.fdntype_id=fdn.id
		WHERE sub.is_foundation=1 AND crs.is_active=1 AND crs.crid='$crid' ORDER BY sub.fdntype_id,crs.semester;";
	$sth=$db->querysoc($q);
	debug($q,"foundation: getFoundationCourses");
	return $sth->fetchAll();

}	/* fxn */

function getAllSubjects($db,$dbg=PDBG,$all=true){
	$dbo=PDBO;
	$cond=($all)? NULL:" WHERE is_foundation=1 ";
	$q="SELECT id,id AS sub,code,name,is_foundation,fdntype_id FROM {$dbo}.`05_subjects` $cond ORDER BY name; ";
	debug($q,"Foundation: getAllSubjects");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

function getCourseGrades($db,$dbg,$crs,$sem=0,$order=NULL,$fields="g.id"){
	$dbo=PDBO;
	$order=empty($order)? $_SESSION['settings']['classlist_order']:$order;
	$grfield=($sem==2)?"g.q6 AS grade":"g.q5 AS grade";
	$q=" SELECT $fields,g.scid,$grfield  
	FROM {$dbg}.50_grades AS g
	INNER JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=g.scid
	WHERE crs.id='$crs';";
	debug($q,"getCourseGrades");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */
