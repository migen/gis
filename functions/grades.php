<?php






/* attd,traits,grades,conduct,conducts,psmapehs */
function getStudentSummary($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;
$q = "SELECT sum.id AS sumid,sum.* FROM {$dbg}.`05_summaries` AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id 
	WHERE sum.`scid`=$scid LIMIT 1; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


/* rcard-chinese */
function getSumo($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;
$q = "SELECT sumo.id AS sumoscid,sumo.*
	FROM {$dbg}.`summaries_other` AS sumo
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sumo.scid = c.id 
	WHERE sumo.`scid` = $scid LIMIT 1;";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



function getCodes($db,$table,$order=NULL,$fields=NULL,$filter=NULL,$limit=NULL){
	$dbo=PDBO;
	$q = "SELECT id,code $fields FROM $table $filter $order $limit ";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$codes = array();
	foreach($rows AS $row){
		$codes[] = $row['code'];
	}
	return $codes;	
}	/* fxn */


function getStudentAttendance($db,$dbg,$sy,$scid){
$dbo=PDBO;
$q = "SELECT att.*,att.id AS attid,c.id AS scid,c.code AS student_code,c.name AS student 
	FROM {$dbg}.05_attendance as att
		INNER JOIN {$dbo}.`00_contacts` AS c ON att.scid 	= c.id	 			
	WHERE att.`scid`=$scid LIMIT 1; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */



function getStudentGrades($db,$dbg,$sy,$crid,$scid){
$dbo=PDBO;
$q = "SELECT tcon.id AS tcid,tcon.code AS teacher_code,tcon.name AS teacher,crs.label AS subject,crs.crid,
		crs.*,g.course_id,g.`id` AS `gid`,g.*
	FROM {$dbg}.`50_grades` AS g
		LEFT JOIN {$dbg}.05_courses AS crs ON (g.course_id = crs.id) 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON (crs.subject_id = sub.id) 		
		LEFT JOIN {$dbo}.`00_contacts` AS tcon ON (crs.tcid = tcon.id) 	
	WHERE crs.`crid`='$crid' AND g.`scid`='$scid' AND crs.`is_active`='1'  	
		AND crs.`is_displayed`='1' AND crs.`crstype_id` <> ".CTYPETRAIT."   
	ORDER BY crs.position,crs.id ; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function getStudentTraits($db,$dbg,$sy,$scid){
	$dbo=PDBO;
	$gf = " g.q1,g.q2,g.q3,g.q4,";
	$q = "SELECT cri.name AS trait,g.id AS gid,
			g.scid AS scid,g.course_id,g.criteria_id, 
			$gf g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5			
		FROM {$dbg}.`50_grades` AS g
			INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id`	  		= crs.`id`
			INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
		WHERE crs.`crstype_id` = '".CTYPETRAIT."' AND g.`scid`=$scid 
		ORDER BY cri.position,cri.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



function getStudentConduct($db,$sy,$scid,$dbg=DBG){ 
	$dbo=PDBO;
	$gf = " g.q1,g.q2,g.q3,g.q4,";
	$q = "SELECT 'Conduct' AS trait,g.id AS gid,g.scid AS scid,g.course_id,$gf  
			g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,g.q5,sum.id AS sumid
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id			
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = g.scid					
		WHERE crs.crstype_id 	= '".CTYPECONDUCT."' AND g.scid=$scid LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */



function getStudentConducts($db,$dbg,$sy,$scid){	
	$dbo=PDBO;
	$q = "SELECT 'Conduct' AS trait,g.scid AS scid,g.*
		FROM {$dbg}.50_grades AS g INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id			
		WHERE crs.crstype_id ='".CTYPECONDUCT."' AND g.scid ='$scid'; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function getStudentPsmapehs($db,$dbg,$sy,$scid){
	$dbo=PDBO;
	$q = "SELECT cri.name AS psmapeh,g.scid AS scid,g.course_id,g.criteria_id,g.*
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs  ON g.course_id	= crs.id
			INNER JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id	= cri.id
		WHERE crs.crstype_id ='".CTYPEPSMAPEH."' AND g.scid=$scid ; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function getAttendanceMonths($db,$level_id,$sy,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT * FROM {$dbg}.05_attendance_months 
			WHERE `level_id` = ".$level_id." LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */



function classGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order="c.`name` ASC",$fields=NULL,$filter=NULL,$limits=NULL){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$limited = (is_null($limits))? '' : "LIMIT $limits";	
	$q="SELECT $fields c.id AS scid,c.code AS student_code,c.name AS student,g.id AS gid,g.* 			
		FROM {$dbg}.`05_summaries` AS summ 
			INNER JOIN {$dbo}.`00_contacts` AS `c` ON summ.`scid`=c.`id`		
			LEFT JOIN {$dbg}.`50_grades` AS `g` ON g.`scid`=summ.`scid`
			LEFT JOIN {$dbg}.05_students AS `s` ON s.`contact_id`=c.`id`
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id=c.id			
		WHERE summ.crid='$crid' AND g.`course_id` = '$course_id' $is_male ORDER BY $order ;";
	debug($q,"gradesFxn classGrades");
	$sth = $db->querysoc($q);
	if(!$sth){ echo "functions-grades: "; pr($q); }	
	return $sth->fetchAll();

}	/* fxn */





