<?php




/* can only edit bonus part of grades,same as for registrar's edit grades */
function editStudentGrades($db,$dbg,$crid,$scid,$sy,$qtr,$ctype=1,$agg=0,$all){	
	$dbo=PDBO;
	$cond 	= ($ctype==1)? " AND (crs.crstype_id = '1' ) " : $ctype ;
	$cond 	.= ($agg)? " " : " AND (crs.is_aggregate = 0) ";

	if($all){ $cond=NULL; }
	$q = "SELECT 
			g.id AS gid,g.course_id,g.scid AS scid,
			g.q$qtr AS grade,
			g.dg$qtr AS dg,g.*,			
			sub.code AS subject_code,crs.label,
			crs.name AS course,crs.course_weight,crs.subject_id,crs.supsubject_id,crs.crstype_id,
			crs.crstype_id AS ctype,cri.name AS criteria
		FROM {$dbg}.`50_grades` AS g 
			LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			LEFT JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id = cri.id
		WHERE g.scid=$scid AND crs.crid=$crid $cond
		ORDER BY crs.label,crs.id,cri.id;";
	debug("functions/editStudentGradesFile: ".$q);
	$_SESSION['q']="EditStudentGrades Fxn and Method ".$q;
	if(isset($_GET['debug'])){ echo "Fxn editStudentGrades : "; pr($q); }	
	$sth 	= $db->querysoc($q);	
	return $sth->fetchAll();


}	/* fxn */
