<?php



function loads($db,$tcid,$dbg=PDBG,$all=false){
	$dbo=PDBO;
	$cond = ($all)? NULL:" AND crs.is_active=1";
 	$q = "SELECT crs.*,crs.id AS course_id,sub.name AS subject,
			cty.name AS crstype,cty.id AS ctype_id,cr.name AS classroom
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.`tcid` =  '$tcid' $cond ORDER BY crs.`crid`,crs.`crstype_id`,crs.`name`; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();	
	
}	/* fxn */


function sessionizeTeacherCrids($db,$dbg,$tcid){
	$dbo=PDBO;
	$q=" SELECT crs.crid,cr.name AS classroom,cr.acid,c.name AS adviser
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		WHERE crs.tcid='$tcid' AND crs.is_active=1 
		GROUP BY cr.id ORDER BY cr.section_id; ";
	$sth=$db->querysoc($q);	
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();	
	$_SESSION['teacher']['rcrids']=&$rows;	
	$_SESSION['teacher']['numcrids']=&$count;
	$crids=buildArray($rows,'crid');
	$_SESSION['teacher']['crids']=&$crids;	
	$_SESSION['teacher']['numcrids']=&$count;	

}	/* fxn */

