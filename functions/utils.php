<?php


function msgAllsubjects($db,$crid,$dbg,$sem=1){
$dbo=PDBO;
$semester = NULL;

$q = "SELECT crs.id AS course_id,crs.name AS course,crs.label,crs.position,crs.subject_id
	FROM {$dbg}.05_courses AS crs	
	WHERE crs.`crid`='$crid' AND crs.`is_active`='1' $semester
	ORDER BY crs.position,crs.id; ";
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
return $rows;


}	/* fxn */



function deleteGrade($db,$dbg,$gid){
	$dbo=PDBO;
	$q = " DELETE FROM {$dbg}.50_grades WHERE `id` = '$gid' LIMIT 1; ";
	$db->query($q);

}	/* fxn */



/* grades */
function msg($db,$dbg,$scid,$crf,$crt,$sub){	/* move student grades */
$dbo=PDBO;
$q = "SELECT sub.name AS subject,a.id AS crsfrid,b.id AS crstoid	
	FROM {$dbo}.`05_subjects` AS sub
	INNER JOIN ( SELECT id,subject_id FROM {$dbg}.05_courses WHERE crid = $crf	) AS a ON a.subject_id = sub.id
	INNER JOIN ( SELECT id,subject_id FROM {$dbg}.05_courses WHERE crid = $crt	) AS b ON b.subject_id = sub.id
	WHERE sub.id = $sub LIMIT 1; ";	
$sth = $db->querysoc($q);
$row = $sth->fetch();

$crsfrid = $row['crsfrid'];
$crstoid = $row['crstoid'];

$q = " UPDATE {$dbg}.50_grades SET `course_id` = '$crstoid' 
WHERE `scid` = '$scid' AND `course_id` = '$crsfrid'; ";
$db->query($q);


}	/* fxn */


function studentInClassroom($db,$dbg,$crf,$scid){	/* strict dbg.05_summaries and dbm.students */
	$dbo=PDBO;
	$q = "SELECT sum.scid AS sumscid,sum.scid AS studscid
		FROM {$dbg}.05_summaries AS sum
		WHERE sum.scid = '$scid' AND sum.crid = '$crf' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */

	
function dsgs($db,$dbg,$crid,$scid){	/* deleteStudentGradesScores */
	$dbo=PDBO;
	$q = "";
	$q .= " DELETE FROM {$dbg}.50_scores WHERE `scid` = '$scid' ; ";
	$q .= " 
		DELETE a FROM {$dbg}.50_grades AS a 
			LEFT JOIN {$dbg}.05_courses AS crs ON a.course_id = crs.id
		WHERE 
				crs.`crid` = '$crid'		
			AND	a.`scid` = '$scid'
	; ";
	$db->query($q);

}	/* fxn */


function sxn($db,$dbg,$scid,$crf,$crt){
	$dbo=PDBO;
	$q = " SELECT id,acid FROM {$dbg}.05_classrooms WHERE `id` = '$crt' ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();

	$q = "";
	$q .= " UPDATE {$dbg}.05_summaries SET `crid` = '$crt',acid = '".$row['acid']."'
		WHERE scid = '$scid' LIMIT 1;	 ";
	$db->query($q);

	$q = " UPDATE {$dbo}.`00_contacts` SET `crid` = '$crt' WHERE `id` = '$scid' LIMIT 1;";	
	$q .= " UPDATE {$dbg}.05_students SET `prevcrid` = '$crf' WHERE `contact_id` = '$scid' LIMIT 1;";		
	$db->query($q);
	


}	/* fxn */
