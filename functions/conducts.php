<?php




/* used by non-k12 conducts */
function getClassroomConducts($db,$dbg,$crid,$course_id,$sy,$qtr,$order){		
	$dbo=PDBO;
	$q = "
		SELECT 
			c.id AS scid,c.id AS scid,c.code AS student_code,c.name AS student,
			g.id AS gid,g.*
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.`05_summaries` AS summ ON g.scid = summ.scid
			LEFT JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
		WHERE summ.crid='$crid' AND g.course_id = '$course_id' 
		ORDER BY $order	;";
	debug($q,"Conducts: getClassroomConducts");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getTraitRanks($db,$dbg,$crid,$course_id,$sy,$qf,$limits=NULL){
	$dbo=PDBO;

	$qfcond  = " ,(sum.conduct_$qf) AS grade,sum.rank_classconduct_$qf AS rank "; 
	$limited = (is_null($limits))? '' : "LIMIT $limits";

	$q = " 
		SELECT 
			sum.`id` AS `sumid`,
			sum.`conduct_q1` AS `q1`,sum.`conduct_q2` AS `q2`,sum.`conduct_q3` AS `q3`,
			sum.`conduct_q4` AS `q4`,sum.conduct_q5 AS final,
			sum.`rank_classconduct_q1` AS `rank_q1`,
			sum.`rank_classconduct_q2` AS `rank_q2`,
			sum.`rank_classconduct_q3` AS `rank_q3`,
			sum.`rank_classconduct_q4` AS `rank_q4`,
			sum.`rank_classconduct_q5` AS `rank_q5`,
			c.id AS scid,c.code AS student_code,c.name AS student
			$qfcond			
		FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.`scid` = s.`contact_id`
		WHERE 				
				sum.crid 	= '$crid' 
			AND	c.is_active 	= 1		
		ORDER BY grade DESC						
		$limited
	";
	
	// pr($q);
	$sth	= $db->querysoc($q);
	return $sth->fetchAll(); 
	
}	/* fxn */
	
