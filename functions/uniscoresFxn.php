<?php


function getUnicriteria($db,$dbg,$subject_id){
	$dbo=PDBO;
	$q="SELECT comp.*,cri.name AS criteria,cri.*,comp.id AS component_id,comp.id AS comp,cri.id AS cri
		FROM {$dbg}.01_components AS comp
		INNER JOIN {$dbg}.01_criteria AS cri ON comp.criteria_id=cri.id
		WHERE comp.subject_id='$subject_id' ORDER BY cri.position,cri.id;
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
}	/* fxn */


function getUniactivities($db,$dbg,$course_id,$sem){
	$dbo=PDBO;
	$q = "SELECT cri.id AS cri,cri.name AS criteria,cri.code AS cricode,cri.is_raw,
			com.*,a.id AS aid,a.name AS activity,a.date,a.max_score 
		FROM {$dbg}.10_activities AS a 
		LEFT JOIN   {$dbg}.01_components AS com ON a.component_id=com.id
		LEFT JOIN {$dbg}.01_criteria AS cri ON com.criteria_id=cri.id
		WHERE a.course_id='$course_id' AND a.semester='$sem'
		ORDER BY cri.position,cri.id,a.id; ";	
	debug($q,'UniscoresFxn: getUniactivities');
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getUniscores($db,$dbg,$course_id,$scid,$sem){
	$dbo=PDBO;
	/* getScoresPerStudent */
	$q = "SELECT sc.*,cri.*,cri.name AS criteria,cri.id AS criteria_id,comp.weight,
		a.id AS aid,a.name AS activity,a.max_score,a.date
		FROM {$dbg}.10_scores AS sc
			LEFT JOIN {$dbg}.10_activities AS a ON sc.activity_id=a.id
			LEFT JOIN {$dbg}.01_components AS comp ON a.component_id=comp.id			
			LEFT JOIN {$dbg}.01_criteria AS cri ON comp.criteria_id=cri.id		
		WHERE sc.course_id='$course_id' AND sc.scid='$scid' AND sc.semester='$sem'
		ORDER BY cri.position,cri.id,a.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */ 


function getUnicourseComponents($db,$dbg,$subject_id,$crs,$sem){
	$dbo=PDBO;
	$q="SELECT comp.id AS comp,cri.id AS cri,cri.name AS criteria 
		FROM {$dbg}.01_components AS comp INNER JOIN {$dbg}.01_criteria AS cri ON comp.criteria_id=cri.id
		WHERE comp.subject_id='$subject_id'; ";
	$sth=$db->querysoc($q);
	$data['crs_components']=$sth->fetchAll();
	$data['crs_num_components']=$sth->rowCount();


	$q = "SELECT a.id AS aid,comp.id AS comp,comp.criteria_id AS cri FROM {$dbg}.10_activities AS a
		INNER JOIN {$dbg}.01_components AS comp ON a.component_id=comp.id
		INNER JOIN {$dbg}.01_courses AS crs ON a.course_id=crs.id
		WHERE a.course_id = '$crs' AND a.semester='$sem' 
		GROUP BY a.component_id;";		
	$sth=$db->querysoc($q);
	$data['acty_components']=$sth->fetchAll();
	$data['acty_num_components']=$sth->rowCount();
	
	return $data;

	
	
}	/* fxn */



// ------------------------------------------------------ k12 bed below ------------------------------------------------------



function editScores($db,$dbg,$course_id,$activity_id,$sy,$crid,$tier=2,$kpup=1){
$dbo=PDBO;
$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];
$q = " SELECT c.id AS student_id,c.code AS student_code,c.name AS student,
		sc.id AS id,sc.score,sc.quarter,sc.is_valid
	FROM {$dbg}.50_scores AS sc 
		INNER JOIN {$dbg}.05_summaries AS summ ON sc.scid = summ.scid 
		INNER JOIN {$dbo}.`00_contacts` AS c ON sc.scid = c.id 
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id 
	WHERE sc.`course_id` = '$course_id' 
		AND sc.`activity_id` = '$activity_id' 
		AND summ.`crid` = '$crid' 
		AND c.`is_active` = '1'
	ORDER BY $order LIMIT 80 ;";
debug($q,'ScoresFxn: editScores');		
$sth = $db->querysoc($q);
$data['scores'] = $sth->fetchAll();


$q = " SELECT a.id AS activity_id,a.name AS activity,a.date,a.max_score,a.component_id,cri.id AS criteria_id,cri.name AS criteria,cri.is_raw ";
if($kpup==1) { 
	$q .= " ,subcri.id AS subcriteria_id,subcri.name AS subcriteria "; 
}
$q .= "	FROM {$dbg}.50_activities AS a
		LEFT JOIN {$dbg}.05_components AS com ON a.component_id = com.id
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id 	";
if($kpup) { 
	$q .= " LEFT JOIN {$dbo}.`05_criteria` AS subcri ON a.subcomponent_id = subcri.id 	"; 
}		
		
$q .= "	WHERE a.`id` = '$activity_id' LIMIT 1; ";
if(isset($_GET['debug'])){ pr($q); }

$sth = $db->querysoc($q);
$data['activity'] = $sth->fetch();
if(isset($_GET['debug'])){ pr($data['activity']); }

return $data;

}	/* fxn */



function scoresRedirect($course,$qtr){
	$dbo=PDBO;
	$sy = $_SESSION['sy'];
	if($course['is_trait'] || $course['is_psmapeh']){
		$url = 'teachers/traits/'.$course['course_id'].DS.$sy.DS.$qtr;							
	} else {
		$url = 'teachers/scores/'.$course['course_id'].DS.$sy.DS.$qtr;								
	}	
	return $url;
}


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
	debug($q,'ScoresFxn: selectsCourseCriteria');		
	$sth = $db->querysoc($q);
	$data['criteria'] = $sth->fetchAll();		
	if($data['crs']['is_kpup'] == 1){
		$q = " SELECT subcri.id AS subcriteria_id,subcri.name AS subcriteria,subcri.is_raw 
				FROM {$dbo}.`05_criteria` AS subcri
				WHERE subcri.is_kpup_list = 1; ";
		$sth = $db->querysoc($q);
		debug($q,'ScoresFxn: selectsCourseCriteria');				
		$data['subcriteria'] = $sth->fetchAll();
	}	
	return $data;
}	/* fxn */


function getCriteriaScores($db,$dbg,$course_id,$criteria_id,$scid,$qtr){	/* 3-tier */
$dbo=PDBO;
/* getScoresPerStudent */
$q = "
	SELECT 
		sc.score,sc.scid AS scid,sc.scid,sc.course_id,	
		sc.id AS score_id,sc.is_valid,sc.quarter,
		com.criteria_id,com.weight,
		a.subcomponent_id AS subcriteria_id,
		a.id AS activity_id,a.name AS activity,
		a.date AS activity_date,
		a.max_score
	FROM {$dbg}.50_scores AS sc		
		LEFT JOIN {$dbg}.50_activities AS a ON sc.activity_id = a.id
		LEFT JOIN {$dbg}.05_components AS com ON a.component_id = com.id		
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id		
	WHERE
			a.`course_id` 			= '$course_id' 
		AND sc.`scid` 	= '$scid' 
		AND sc.`quarter` 			=  '$qtr'
		AND com.`criteria_id` 		= '$criteria_id'
	ORDER BY cri.`position`,com.`criteria_id`,a.`subcomponent_id`,a.`id` 
";

debug($q,'ScoresFxn: getCriteriaScores');
$sth = $db->querysoc($q);
$score = $sth->fetchAll();

return $score;

}	/* fxn */


function getActivities($db,$dbg,$course_id,$qtr,$fields="cri.id"){
	$dbo=PDBO;
	$q = "SELECT $fields,cri.id AS criteria_id,cri.name AS criteria,cri.code AS criteria_code,
			com.weight,cri.is_raw,a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score 
		FROM {$dbg}.50_activities AS a 
		LEFT JOIN   {$dbg}.05_components AS com ON (com.id = a.component_id)
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON (cri.id = com.criteria_id)
		WHERE a.course_id = $course_id  AND a.quarter = $qtr
		ORDER BY cri.position,cri.id,a.id; ";	
	debug($q,'ScoresFxn: getActivities');
	if(isset($_GET['debug'])){ echo "Fxn scores: getActivities: "; pr($q); }	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function deleteScores($db,$dbg,$course_id,$activity_id){
	$dbo=PDBO;
	$qry = '';
	$q = " DELETE FROM {$dbg}.50_activities where id = $activity_id ";
	$r = $db->query($q);
	if(!$r){ pr($q); die('Query failed.'); return false; }		
	debug($q);
	$qry .= $q;

	$q = " DELETE FROM {$dbg}.50_scores WHERE course_id = '$course_id' AND activity_id = '$activity_id' LIMIT 50 ";
	$r = $db->query($q);
	if(!$r){ pr($q); die('Query failed.'); return false; }		
	debug($q);	
	$qry .= $q;
	return true;

}   /* fxn */



function getScoresKpup($db,$dbg,$course_id,$scid,$qtr){		/* 3-tier */
$dbo=PDBO; 
/* getScoresPerStudent	 */
$q = "SELECT sc.scid AS scid,sc.scid,sc.course_id,sc.id AS score_id,sc.is_valid,sc.quarter,
		com.criteria_id,com.weight,subcri.is_raw,a.subcomponent_id AS subcriteria_id,
		a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score,sc.score
	FROM {$dbg}.50_scores AS sc		
		LEFT JOIN {$dbg}.50_activities AS a ON sc.activity_id = a.id
		LEFT JOIN {$dbg}.05_components AS com ON a.component_id = com.id		
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id		
		LEFT JOIN {$dbo}.`05_criteria` AS subcri ON a.subcomponent_id = subcri.id		
	WHERE a.course_id = '$course_id' AND sc.scid = '$scid' AND sc.quarter =  '$qtr'
	ORDER BY cri.position,com.criteria_id,a.subcomponent_id,a.id; ";
$sth = $db->querysoc($q);
$score = $sth->fetchAll();
return $score;

}	/* fxn */


function getScores($db,$dbg,$course_id,$scid,$qtr,$fields="sc.id"){	/* 3-tier */
$dbo=PDBO;
/* getScoresPerStudent */
$q = "SELECT $fields,sc.scid AS scid,sc.scid,sc.course_id,sc.id AS score_id,sc.is_valid,sc.score,sc.quarter,
		cri.is_raw,com.criteria_id,com.weight,a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score	
	FROM {$dbg}.50_scores AS sc
		LEFT JOIN {$dbg}.50_activities AS a ON sc.activity_id = a.id
		LEFT JOIN {$dbg}.05_components AS com ON a.component_id = com.id			
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id		
	WHERE sc.course_id = '$course_id' AND sc.scid = '$scid' AND sc.quarter = '$qtr'
	ORDER BY cri.position,com.criteria_id,a.id; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */ 




function getCriteriaActivities($db,$dbg,$course_id,$criteria_id,$qtr){
	$dbo=PDBO;
	$q = "
		SELECT cri.id AS criteria_id,cri.name AS criteria,com.weight,cri.is_raw,
			a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score
		FROM {$dbg}.50_activities AS a 
		LEFT JOIN   {$dbg}.05_components AS com ON (com.id = a.component_id)
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON (cri.id = com.criteria_id)
		WHERE 	
				a.`course_id` 		= '$course_id' 
			AND a.`quarter` 		= '$qtr'
			AND com.`criteria_id` 	= '$criteria_id'
		ORDER BY cri.`position`,cri.`id`,a.`id` 	
	";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


	
function editStudentScores($db,$dbg,$course_id,$scid,$qtr){
	$dbo=PDBO;
	$q = " SELECT sc.*,sc.id AS score_id,a.*,a.id AS activity_id,a.name AS activity,
			c.id AS scid,c.code AS student_code,c.name AS student
		FROM {$dbg}.50_scores AS sc 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sc.scid = c.id
			LEFT JOIN {$dbg}.50_activities AS a ON sc.activity_id = a.id
		WHERE 
			sc.course_id = '$course_id' AND sc.quarter = '$qtr' AND sc.scid = '$scid'; ";	
	if(isset($_GET['debug'])){ echo "Fxn scores > editStudentScores: "; pr($q); }				
	$sth = $db->querysoc($q);	
	return $sth->fetchAll();

}	/* fxn */


