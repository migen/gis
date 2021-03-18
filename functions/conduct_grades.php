<?php

function getConductGrades($db,$dbg,$crid,$course_id,$sy,$qtr,$order){
$dbo=PDBO;
$q = " SELECT c.chinese_name,
		sum.id AS sumid,sum.scid AS scid,
		sum.conduct_q1 AS q1,sum.conduct_q2 AS q2,sum.conduct_q3 AS q3,
		sum.conduct_q4 AS q4,sum.conduct_q5 AS q5,sum.conduct_q6 AS q6,		
		sum.conduct_dg1 AS dg1,sum.conduct_dg2 AS dg2,sum.conduct_dg3 AS dg3,
		sum.conduct_dg4 AS dg4,sum.conduct_dg5 AS dg5,sum.conduct_dg6 AS dg6,
		c.name AS student
	FROM {$dbg}.05_summaries AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
	WHERE sum.crid = $crid ORDER BY $order;";

debug($q,"Fxn-conduct_grades ");	
$sth = $db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */


