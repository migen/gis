<?php

function studentGrades($db,$dbg,$sy,$scid,$course_id,$fields=NULL,$filter=NULL){	/* OgController-scores */
	$dbo=PDBO;
	$q = "SELECT c.id AS scid,c.code AS student_code,c.name AS student,g.id AS gid,g.* $fields
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`			
			LEFT JOIN {$dbg}.`50_grades` AS `g` ON g.`scid` = c.`id`
		WHERE g.`course_id`='$course_id' AND sum.`scid`='$scid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order="c.`name` ASC",$fields=NULL,$filter=NULL,$limits=NULL){
	$dbo=PDBO;	
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$limited = (is_null($limits))? '' : "LIMIT $limits";
	
	$q = "SELECT c.id AS scid,c.code AS student_code,c.name AS student,g.id AS gid,g.* $fields
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`			
			LEFT JOIN {$dbg}.`50_grades` AS `g` ON g.`scid` = c.`id`
		WHERE g.`course_id`='$course_id' AND sum.`crid`='$crid' $is_male ORDER BY $order; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function student($db,$dbg,$sy,$scid,$fields=NULL){
	$dbo=PDBO;	
	$q = "SELECT c.`id` AS `scid`,c.`code` AS `student_code`,c.`name` AS `student`,				
			c.crid AS scrid,sum.`crid` AS `crid`,sum.`id` AS `sumid`,c.`sy` AS sy,sum.`acid` AS acid,				
			sum.ave_q1 AS ag1,sum.ave_q2 AS ag2,sum.ave_q3 AS ag3,sum.ave_q4 AS ag4,sum.ave_q5 AS agf,
			sum.ave_dg1 AS adg1,sum.ave_dg2 AS adg2,sum.ave_dg3 AS adg3,sum.ave_dg4 AS adg4,sum.ave_dg5 AS adgf,					
			sum.conduct_q1 AS cg1,sum.conduct_q2 AS cg2,sum.conduct_q3 AS cg3,sum.conduct_q4 AS cg4,sum.conduct_q5 AS cgf,
			sum.conduct_dg1 AS cdg1,sum.conduct_dg2 AS cdg2,sum.conduct_dg3 AS cdg3,sum.conduct_dg4 AS cdg4,sum.conduct_dg5 AS cdgf,
			p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,						
			cr.*,cr.name AS classroom,l.*,l.name AS level,sec.name AS section,
			sum.*,p.*,s.*,c.*,sum.crid AS crid $fields					
		FROM {$dbo}.`00_contacts` AS `c` 		
			LEFT JOIN {$dbo}.`00_profiles` AS `p` ON p.`contact_id` = c.id
			LEFT JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = c.`id`
			LEFT JOIN {$dbg}.05_students AS `s` ON s.`contact_id` = c.`id`
			LEFT JOIN {$dbg}.05_classrooms AS `cr` ON sum.`crid` = cr.`id`
			LEFT JOIN {$dbo}.`05_levels` AS `l` ON cr.`level_id` = l.`id`
			LEFT JOIN {$dbo}.`05_sections` AS `sec` ON cr.`section_id` = sec.`id`
		WHERE c.`id`='$scid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row;


}	/* fxn */


	
function students($db,$dbg=PDBG,$active_only=true,$fields=NULL){
	$dbo=PDBO;
	$cond = ($active_only)? " AND c.`is_active` = '1' ":NULL;
	$q = "SELECT c.id,c.code,c.name,c.crid $fields
		FROM {$dbo}.`00_contacts` AS c 
		WHERE c.`role_id`=".RSTUD." $cond
		ORDER BY c.`name` ASC; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */
