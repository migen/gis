<?php



function getTraitsByColumn($db,$dbg,$qtr,$crid,$course_id,$criteria_id,$sort){
	$dbo=PDBO;
	$qqtr='q'.$qtr;
	$q = "
		SELECT 
			c.id AS student_id,c.id AS scid,c.code AS student_code,c.name AS student,
			g.id AS gid,g.{$qqtr} AS grade,g.dg{$qtr} AS dg
		FROM {$dbg}.50_grades AS g 
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id 
			INNER JOIN {$dbg}.`05_summaries` AS summ ON c.id = summ.scid 
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id 
		WHERE 
				summ.`crid` = '$crid' 		
			AND g.`course_id` = '$course_id' 
			AND g.`criteria_id` = '$criteria_id' 
		ORDER BY $sort LIMIT 100 ; ";
	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getCavStudentsByLevel($db,$lvl,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q="
		SELECT c.id AS scid,c.name AS student,cr.name AS classroom,summ.id AS sumid,
			summ.conduct_q{$qtr} AS dbave,summ.conduct_dg{$qtr} AS dbletter
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		WHERE cr.level_id='$lvl' AND c.is_active=1 AND cr.section_id>2		
		ORDER BY cr.name,c.name 
	";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getCavCriteriaByLevel($db,$lvl,$dbg=PDBG){
	$dbo=PDBO;
	$q="
		SELECT cri.id AS criteria_id,cri.name AS criteria,cri.code AS criteria_code,com.weight
		FROM {$dbg}.05_components AS com 
		INNER JOIN {$dbo}.`05_criteria` AS cri ON cri.id=com.criteria_id
		INNER JOIN {$dbo}.`05_subjects` AS sub ON sub.id=com.subject_id
		WHERE sub.crstype_id=2 AND com.level_id='$lvl' 
		ORDER BY cri.position,cri.id
	";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */




function getCavByStudent($db,$scid,$qtr,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT comp.weight,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id,g.q{$qtr} AS grade,g.dg{$qtr} AS letter
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbo}.`00_contacts` AS `c`  ON g.`scid` = c.`id`
			INNER JOIN {$dbg}.`05_summaries` AS `summ`  ON summ.`scid` = c.`id`
			INNER JOIN {$dbg}.05_classrooms AS `cr`  ON summ.`crid` = cr.`id`			
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_subjects` AS `sub`  ON sub.`id` = crs.`subject_id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
			INNER JOIN {$dbg}.05_components AS `comp` ON (comp.`criteria_id` = cri.`id` AND comp.level_id = cr.level_id) 
		WHERE crs.`crstype_id` = '2' AND g.`scid` = '$scid' ORDER BY cri.position,cri.id;";		
	$sth=$db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */
