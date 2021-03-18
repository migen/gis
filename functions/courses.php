<?php

function initStats($dgid){
	$stats = array();
	foreach($dgid AS $i){
		$stats[$i] = 0;
	}
	return $stats;
}	/* fxn */


function countStats($grade,$ratings,$stats){
	foreach($ratings AS $r){
		if($grade>=$r['grade']){
			$i = $r['dgid'];
			$stats[$i]+=1;
			break;
		}
	}
	return $stats;
}	/* fxn */
	

function getCourseFloorGrade($course,$settings){
	if($course['is_ps']){
		return $settings['floor_grade_ps'];
	} elseif($course['is_gs']){
		return $settings['floor_grade_gs'];
	} elseif($course['is_hs']){
		return $settings['floor_grade_hs'];
	} 	
}	/* fxn */


function getConductFloorGrade($course,$settings){
	if($course['is_ps']){
		return $settings['floor_conduct_ps'];
	} elseif($course['is_gs']){
		return $settings['floor_conduct_gs'];
	} elseif($course['is_hs']){
		return $settings['floor_conduct_hs'];
	} 	
}	/* fxn */
	

function getStatsByCourse($db,$dbg,$sy,$course_id){
	$q = " SELECT * FROM {$dbg}.50_stats WHERE `course_id` = '$course_id' ; ";
	$sth 	= $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function courseGrades($db,$dbg,$crid,$course_id,$sy,$sort="c.is_male DESC,c.name",$order="ASC",$fields=NULL){
	$dbo=PDBO;
	$condsort=" ORDER BY $sort $order ";
	/* returns class records */	
	$q  = " SELECT g.id,g.id AS gid,c.id AS scid,c.id AS contact_id,c.code AS student_code,c.name as student,c.is_male,g.* $fields
		FROM {$dbg}.`50_grades` AS `g` 
			INNER JOIN {$dbg}.`05_summaries` AS summ ON g.scid = summ.scid 
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id 
		WHERE g.course_id 	= '$course_id' AND summ.crid 	= '$crid' $condsort LIMIT 100 ;";		
	debug($q,"courses: courseGrades ");	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function getCourseBySubject($db,$sub,$crid,$dbo,$dbg){
$dbo=PDBO;
$q="SELECT 
		crs.id AS crs,crs.tcid,c.name AS teacher,sub.name AS subject,sub.id AS sub,
		crs.*,sup.code AS supsubject
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbo}.`05_subjects` AS sup ON crs.supsubject_id=sup.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	WHERE crs.`subject_id`=$sub AND crs.`crid`=$crid LIMIT 1; ";
// debug($q,"courses: getCourseBySubject ");
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



