<?php


	
function getCourseRanks($db,$dbg,$crid,$course_id,$sy,$qf,$limits=NULL){
	$dbo=PDBO;
	$qfcond = " ,g.$qf AS grade,g.rank_$qf AS rank "; 
	$limited = (is_null($limits))? '' : "LIMIT $limits";
	$rqf='r'.$qf;
	$q=" SELECT g.id AS gid,g.scid  AS scid,c.code AS student_code,c.name AS student,g.*,g.$rqf AS raw $qfcond						
		FROM {$dbg}.`50_grades` AS `g` 
		INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid=c.id 
		INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid=c.id 			
		WHERE g.course_id 	= '$course_id' AND c.is_active='1' AND sum.crid='$crid'								
		ORDER BY g.in_rank DESC,raw DESC,grade DESC $limited ";				
	debug($q);
	$sth	= $db->querysoc($q);
	return $sth->fetchAll(); 
	
}	/* fxn */
	
