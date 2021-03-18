<?php


function xxxgetClasslist($db,$dbg,$crid,$order){
	$dbo=PDBO;
	$q="SELECT summ.scid,c.name AS student
	FROM {$dbo}.`00_contacts` AS c
	INNER JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id
	WHERE summ.crid='$crid' ORDER BY $order; ";
	debug($q,"spiral-getClasslist");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getComponentCourses($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT crs.id,crs.id AS crs,crs.name,crs.label,crs.subject_id,crs.supsubject_id,sup.id AS supcrs,crs.code,
		0 AS `is_tally`,crs.course_weight AS wt
		FROM {$dbg}.`05_courses` AS crs 
		LEFT JOIN (
			SELECT * FROM {$dbg}.`05_courses` WHERE crid='$crid'
		) AS sup ON crs.supsubject_id=sup.subject_id 
		WHERE (crs.crid='$crid') AND (crs.supsubject_id>0)
		ORDER BY crs.supsubject_id,crs.label ;
	";
	debug($q,"spiral-getComponentCourses");	
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getCourseGrades($db,$dbg,$crid,$crs,$qtr,$order){
	$dbo=PDBO;
	$q=" SELECT g.scid,g.q{$qtr} AS grade,crs.course_weight AS wt
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		INNER JOIN {$dbg}.50_grades AS g ON summ.scid=g.scid
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		WHERE summ.crid='$crid' AND g.course_id='$crs' ORDER BY $order; ";
	$sth=$db->querysoc($q);			
	return $sth->fetchAll();

}	/* fxn */

function getAggregateCourse($db,$dbg,$supcrs){
	$dbo=PDBO;
	$q="SELECT crs.id,crs.id AS crs,crs.name,crs.label,crs.subject_id,crs.supsubject_id,crs.code,
		0 AS supcrs,1 AS `is_tally`,crs.course_weight AS wt
	FROM {$dbg}.`05_courses` AS crs WHERE crs.id='$supcrs' LIMIT 1;";
	debug($q,"spiral-getAggregateCourses");	
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */
