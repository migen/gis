<?php



function selectsCourseCriteria($db,$course_id,$dbg=PDBG){
	$dbo=PDBO;
	$data['crs'] = getCourseDetails($db,$course_id,$dbg);
	$_SESSION['course'] = $data['crs'];
	
	$q = "
		SELECT cri.id AS criteria_id,cri.name AS criteria,cri.is_raw,
			com.weight,com.id AS component_id
		FROM   {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
		WHERE
			com.level_id =  '".$data['crs']['level_id']."' AND
			com.subject_id =  '".$data['crs']['subject_id']."'	
	";
	if(isset($_GET['debug'])){ echo "Fxn scores: selectsCourseCriteria: "; pr($q); }
	
	$sth = $db->querysoc($q);
	$data['criteria'] = $sth->fetchAll();	
	
	if($data['crs']['is_kpup'] == 1){
		$q = " SELECT subcri.id AS subcriteria_id,subcri.name AS subcriteria,subcri.is_raw 
				FROM {$dbo}.`05_criteria` AS subcri
				WHERE subcri.is_kpup_list = 1
		";
		$sth = $db->querysoc($q);
		$data['subcriteria'] = $sth->fetchAll();
	}
		
	
	return $data;
}	/* fxn */



function getPactivities($db,$dbg,$course_id,$qtr,$sy){
	$dbo=PDBO;$dbp=PDBP;
	$q = "
		SELECT cri.id AS criteria_id,cri.name AS criteria,cri.code AS criteria_code,
			com.weight,cri.is_raw,
			a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score
		FROM {$dbp}.{$sy}_50_activities AS a 
		LEFT JOIN   {$dbg}.05_components AS com ON (com.id = a.component_id)
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON (cri.id = com.criteria_id)
		WHERE 	a.course_id = $course_id 
			AND a.quarter = $qtr
		ORDER BY cri.position,cri.id,a.id 	
	";	
	debug($q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



function getPscores($db,$dbg,$course_id,$scid,$qtr,$sy){	/* 3-tier */
$dbo=PDBO;
$dbp=PDBP;

/* getScoresPerStudent */
$q = "SELECT 
		sc.scid AS scid,sc.scid,sc.course_id,	
		sc.id AS score_id,sc.is_valid,sc.score,sc.quarter,
		cri.is_raw,
		com.criteria_id,com.weight, 
		a.id AS activity_id,a.name AS activity,
		a.date AS activity_date,a.max_score	
	FROM {$dbp}.{$sy}_50_scores AS sc
		LEFT JOIN {$dbp}.{$sy}_50_activities AS a ON sc.activity_id = a.id
		LEFT JOIN {$dbg}.05_components AS com ON a.component_id = com.id			
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id		
	WHERE sc.course_id=$course_id AND
		sc.scid=$scid AND
		sc.quarter=$qtr
	ORDER BY cri.position,com.criteria_id,a.id; ";
debug($q);
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */ 




	