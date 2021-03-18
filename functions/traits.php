<?php

function getCritype($db,$dbg,$crs,$critype_id){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";
	$q="SELECT cri.critype_id,cty.name AS critype,COUNT(cri.critype_id) AS `num`
		FROM {$dbg}.05_components AS com 
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id=cri.id 
			INNER JOIN {$dbo}.`05_critypes` AS cty ON cri.critype_id=cty.id 
			INNER JOIN {$dbg}.05_courses AS crs ON crs.subject_id=com.subject_id  
			INNER JOIN {$dbg}.05_classrooms as cr ON crs.crid=cr.id AND com.level_id=cr.level_id 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id
		WHERE crs.id='$crs' AND cri.critype_id=$critype_id GROUP BY cri.critype_id ORDER BY $order; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getCritypes($db,$dbg,$crs){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";
	$q="SELECT cri.critype_id,cty.name AS critype,COUNT(cri.critype_id) AS `num`
		FROM {$dbg}.05_components AS com 
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id=cri.id 
			INNER JOIN {$dbo}.`05_critypes` AS cty ON cri.critype_id=cty.id 
			INNER JOIN {$dbg}.05_courses AS crs ON crs.subject_id=com.subject_id  
			INNER JOIN {$dbg}.05_classrooms as cr ON crs.crid=cr.id AND com.level_id=cr.level_id 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id
		WHERE crs.id='$crs' GROUP BY cri.critype_id ORDER BY $order; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

function getTraitsCrsByCrid($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT crs.id AS crs,crs.name AS course
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		WHERE crs.crstype_id='".CTYPETRAIT."' AND crs.crid='$crid';";
	debug($q,"cavFxn: getTraitsCrsByCrid ");
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function getTraitsCriteria($db,$course_id,$dbg=PDBG){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";
	$q = "SELECT com.weight,cri.id AS criteria_id,cri.name AS criteria,cri.code,crs.id AS course_id,cri.critype_id 
		FROM {$dbg}.05_components AS com 
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id 
			INNER JOIN {$dbg}.05_courses AS crs ON crs.subject_id = com.subject_id  
			INNER JOIN {$dbg}.05_classrooms as cr ON crs.crid = cr.id and com.level_id = cr.level_id 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id			
		WHERE crs.id = '$course_id' ORDER BY $order; ";
	debug($q,"traitsFxn: getTraitsCriteria");
	// pr($q);echo '<hr />';
	$sth = $db->querysoc($q);
	return $sth->fetchAll();	

}	/* fxn */

function getTraitsCriteriaByCritype($db,$course_id,$critype_id,$dbg=PDBG){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";
	$q = "SELECT com.weight,cri.id AS criteria_id,cri.name AS criteria,cri.code,crs.id AS course_id,cri.critype_id 
		FROM {$dbg}.05_components AS com 
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id 
			INNER JOIN {$dbg}.05_courses AS crs ON crs.subject_id = com.subject_id  
			INNER JOIN {$dbg}.05_classrooms as cr ON crs.crid = cr.id and com.level_id = cr.level_id 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id			
		WHERE crs.id = '$course_id' AND cri.critype_id = '$critype_id' 		
		ORDER BY $order; ";
	debug($q,"traitsFxn: getTraitsCriteriaByCritype");
	// pr($q);echo '<hr />';
	$sth = $db->querysoc($q);
	return $sth->fetchAll();	

}	/* fxn */

/* one crsid with multiple grades for traits in criteria  */
function syncStudentTraits($db,$dbg,$course_id,$scid,$sy,$qtr){	
	$dbo=PDBO;
	$q = "SELECT g.id AS gid,g.course_id,g.scid AS scid,g.q$qtr AS grade,g.criteria_id,crs.name AS course,
			cri.name AS criteria,cri.code AS criteria_code
		FROM {$dbg}.50_grades AS g 
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
			INNER JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id = cri.id			
			INNER JOIN {$dbg}.05_students AS s ON g.scid = s.contact_id
		WHERE g.course_id = '$course_id' AND g.scid='$scid' ORDER BY cri.id LIMIT 100; ";
	$sth=$db->querysoc($q);	
	return $sth->fetchAll();

}	/* fxn */



function editStudentTraitsDG($db,$dbg,$course_id,$scid,$sy,$qtr){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"cri.position,cri.id";
	$q = "SELECT g.id AS gid,g.q$qtr AS grade,g.dg$qtr AS dg,summ.conduct_q{$qtr} AS final,summ.conduct_dg{$qtr} AS dgfinal,
			g.criteria_id,c.id AS scid,c.code AS student_code,c.name AS student,cri.name AS criteria,cri.code AS criteria_code
		FROM {$dbg}.50_grades AS g 
			INNER JOIN {$dbg}.05_summaries AS summ ON g.scid = summ.scid
			INNER JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id = cri.id
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
		WHERE g.course_id 	= '$course_id' AND g.scid = '$scid' ORDER BY $order; ";
	$sth=$db->querysoc($q);	
	return $sth->fetchAll();

}	/* fxn */


function editStudentTraits($db,$dbg,$course_id,$scid,$sy,$qtr){
	$dbo=PDBO;
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"cri.position,cri.id";
	$q = " SELECT g.id AS gid,g.q$qtr AS grade,g.dg$qtr AS dg,g.criteria_id,
			c.id AS scid,c.code AS student_code,c.name AS student,cri.name AS criteria,cri.code AS criteria_code
		FROM {$dbg}.50_grades AS g 
			INNER JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id = cri.id
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
		WHERE g.course_id 	= '$course_id' AND g.scid = '$scid' ORDER BY $order; ";
	$sth 	= $db->querysoc($q);	
	return $sth->fetchAll();

}	/* fxn */




function getStudentTraitsByCourse($db,$dbg,$sy,$scid,$course_id){
	$dbo=PDBO;
	$gf = " g.q1,g.q2,g.q3,g.q4,g.q5,g.q6,";
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";

	$q = "SELECT comp.weight,g.id AS gid,g.scid AS scid,g.* 			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbo}.`00_contacts` AS `c`  ON g.`scid` = c.`id`
			INNER JOIN {$dbg}.`05_summaries` AS `summ`  ON summ.`scid` = c.`id`
			INNER JOIN {$dbg}.05_classrooms AS `cr`  ON summ.`crid` = cr.`id`			
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
			INNER JOIN {$dbg}.05_components AS `comp` ON (comp.`criteria_id` = cri.`id` AND comp.level_id = cr.level_id) 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id
		WHERE crs.`id` = '$course_id' AND	g.`scid` 	= '$scid' ORDER BY $order; ";	
	$_SESSION['q']=$q;
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function getStudentTraitsByCourseByCritype($db,$dbg,$sy,$scid,$course_id,$critype_id){
	$dbo=PDBO;
	$gf = " g.q1,g.q2,g.q3,g.q4,g.q5,g.q6,";
	$order=isset($_SESSION['settings']['cav_order'])? $_SESSION['settings']['cav_order']:"ct.id,cri.position,cri.id";
		
	$q = "SELECT comp.weight,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id, 
			$gf g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,g.dg6			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbo}.`00_contacts` AS `c`  ON g.`scid` = c.`id`
			INNER JOIN {$dbg}.`05_summaries` AS `summ`  ON summ.`scid` = c.`id`
			INNER JOIN {$dbg}.05_classrooms AS `cr`  ON summ.`crid` = cr.`id`			
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
			INNER JOIN {$dbg}.05_components AS `comp` ON (comp.`criteria_id` = cri.`id` AND comp.level_id = cr.level_id) 
			LEFT JOIN {$dbo}.`05_critypes` AS ct ON cri.critype_id=ct.id
		WHERE crs.`id`='$course_id' AND	cri.`critype_id`= '$critype_id' AND	g.`scid`= '$scid' 		
		ORDER BY $order; ";	
	$_SESSION['q']=$q;
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



