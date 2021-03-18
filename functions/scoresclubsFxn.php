<?php

function getClublistWithGrades($db,$dbg,$club_id,$qtr,$sort){
	$dbo=PDBO;		
	$q=" SELECT summ.scid,c.name AS student,g.`q{$qtr}` AS grade,g.course_id 
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid 
		LEFT JOIN {$dbg}.50_grades AS g ON g.scid=summ.scid 
		WHERE summ.club_id='$club_id' AND c.is_active=1 ORDER BY $sort; ";		
	debug($q);		
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getRatingsClub($db,$dept_id=5,$dbg=PDBG){			 				 		
	$dbo=PDBO;
	$q=" SELECT id AS dgid,rating,grade_floor AS grade FROM {$dbg}.clubratings
		WHERE `dept_id`='$dept_id' ORDER BY grade_floor desc; ";		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
			
}	/* fxn */


function getClubActivities($db,$dbg,$club_id){
	$dbo=PDBO;
	$q="SELECT a.*,a.id AS act_id,cc.weight FROM {$dbg}.`50_clubactivities` AS a 
		LEFT JOIN {$dbg}.`05_clubcomponents` AS cc ON (cc.club_id=a.club_id && cc.clubcriteria_id=a.clubcriteria_id)
		WHERE a.club_id='$club_id' ORDER BY a.`clubcriteria_id`; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

function getClubscores($db,$dbg,$club_id,$scid,$qtr,$sort){
$dbo=PDBO;
$q = "SELECT 
		sc.scid AS scid,sc.scid,sc.club_id,	
		sc.id AS score_id,sc.score,sc.quarter,
		cri.is_raw,
		com.clubcriteria_id,com.weight, 
		a.id AS activity_id,a.name AS activity,
		a.date AS activity_date,a.max_score	
	FROM {$dbg}.`50_scores_club` AS sc
		LEFT JOIN {$dbg}.`50_clubactivities` AS a ON sc.clubactivity_id = a.id
		LEFT JOIN {$dbg}.`05_clubcomponents` AS com ON a.clubcriteria_id = com.clubcriteria_id			
		LEFT JOIN {$dbg}.`05_clubcriteria` AS cri ON com.clubcriteria_id = cri.id		
	WHERE sc.club_id = '$club_id' AND sc.scid = '$scid' AND sc.quarter =  '$qtr'
	ORDER BY cri.position,com.clubcriteria_id,a.id; ";
debug("scoresclubsFxn: ".$q);
$sth = $db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */


function getColumnScores($db,$dbg,$act_id,$sort){	/* 3-tier */
$dbo=PDBO;
$q=" SELECT sc.*,
		a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score			
	FROM {$dbg}.50_scores_club AS sc
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sc.scid = c.id
		LEFT JOIN {$dbg}.clubactivities AS a ON sc.clubactivity_id = a.id
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON a.criteria_id = cri.id
		LEFT JOIN {$dbg}.clubcomponents AS cc ON (cc.criteria_id=a.criteria_id AND cc.club_id=a.club_id)
	WHERE sc.clubactivity_id='$act_id' ORDER BY $sort; ";
$sth=$db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */






	

