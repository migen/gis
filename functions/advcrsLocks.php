<?php

function lockerCourse($db,$dbg,$crs){
	$dbo=PDBO;
	$q="SELECT l.*,crs.name AS course,c.`name` AS `teacher`,cr.acid 
		FROM {$dbg}.`05_courses_quarters` AS l 
		INNER JOIN {$dbg}.`05_courses` AS crs ON l.course_id=crs.id 
		INNER JOIN {$dbg}.`05_classrooms` AS cr ON crs.crid=cr.id 
		INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id 
		WHERE l.`course_id`='$crs' LIMIT 1; ";

	$q="SELECT l.*,crs.name AS course,c.`name` AS `teacher`,cr.acid,sup.id AS supcrs 
		FROM {$dbg}.`05_courses_quarters` AS l 
		INNER JOIN {$dbg}.`05_courses` AS crs ON l.course_id=crs.id 
		
		INNER JOIN {$dbg}.`05_courses` AS sup ON (crs.supsubject_id=sup.subject_id AND crs.crid=sup.crid)
		INNER JOIN {$dbg}.`05_classrooms` AS cr ON crs.crid=cr.id 
		INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id 
		WHERE l.`course_id`='$crs' LIMIT 1; ";		
	pr($q);
		
	debug($q,'advcrsLocksFxn: lockerCourse');
	$sth=$db->querysoc($q);
	// $row=$sth->fetch();
	// pr($row);
	
	return $sth->fetch();
}	/* fxn */


function lockerAdvisory($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT l.*,cr.name AS classroom,c.name AS `adviser` FROM {$dbg}.`05_advisers_quarters` AS l 
		INNER JOIN {$dbg}.`05_classrooms` AS cr ON l.crid=cr.id 
		INNER JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id 
		WHERE l.`crid`='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

