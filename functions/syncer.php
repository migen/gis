<?php



function syncGrades($db,$dbg,$crid,$sy,$ctype=1){
$dbo=PDBO;
require_once(SITE."functions/reports.php");
$today = $_SESSION['today'];	

$students = classyear($db,$dbg,$sy,$crid);		/* GModel */
$courses = cridCourses($db,$dbg,$crid,$acad=$ctype,$agg=1);
$ar = buildArray($courses,'course_id');

/* 1 - sync Grades  ------------------------------------------------------------------ */
foreach($students AS $row){ 
	$scid = $row['scid'];
	$q = " SELECT course_id FROM {$dbg}.50_grades WHERE `crstype_id` = '".$ctype."'  AND `scid` = '$scid'; ";
	$sth = $db->querysoc($q);
	$courses = $sth->fetchAll();
	$br = buildArray($courses,'course_id');
		
	$ix = array_diff($ar,$br);
	
	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_grades (`course_id`,`scid`,`crstype_id`) VALUES  ";
		foreach($ix AS $crs){
			$q .= " ('$crs','$scid','".$ctype."'),";
		}
		$q=rtrim($q,",");$q.=";";$db->query($q);
	}

}	/* foreach-students */


}	/* fxn */



function syncTuitionSummaries($db,$dbg=PDBG){	 
	$dbo=PDBO;	
	$q = " SELECT summ.scid FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	WHERE c.role_id='".RSTUD."' AND cr.section_id <> '2'; ";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'scid');	
		
	/* 2 - */ 
	$q = " SELECT tsum.scid FROM {$dbg}.03_tsummaries AS tsum
			INNER JOIN {$dbo}.`00_contacts` AS c ON tsum.scid = c.id
			WHERE c.`role_id`='".RSTUD."'; ";					
	$sth 	= $db->querysoc($q);
	$tsum 	= $sth->fetchAll();
	$br 	= buildArray($tsum,'scid');

	/* 3 - ix */
	$ix = array_diff($ar,$br);

	/* 4 -tsum */
	$q = " INSERT INTO {$dbg}.03_tsummaries (`scid`) VALUES ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; "; 
	$db->query($q);

	
	$q = " 
		UPDATE {$dbg}.03_tsummaries AS a 
		INNER JOIN (
			SELECT 
				c.id AS contact_id,summ.crid,cr.acid,t.total
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id		
				INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id		
				INNER JOIN {$dbo}.`03_tuitions` AS t ON (cr.level_id = t.level_id && cr.num=t.num)
			WHERE c.is_active = '1'
		) AS b ON a.scid = b.contact_id 
		SET a.balance=b.total,a.assessed=b.total;";				
	$db->query($q);
	
}	/* fxn */



function syncSummaries($db,$dbg,$sy){
	$dbo=PDBO;
	/* 1 */
	$q = " SELECT `id` AS `cid` FROM {$dbo}.`00_contacts` WHERE id=parent_id AND `role_id`=1 ORDER BY id; ";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'cid');
	
	/* 2 */
	$q = " SELECT summ.`scid` AS `cid` FROM {$dbg}.05_summaries AS summ
			ORDER BY summ.scid; ";	
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'cid');

	/* 3 */
	$ix = array_diff($ar,$br);
	
	$q = " INSERT INTO {$dbg}.05_summaries (`scid`) VALUES  ";
	foreach($ix AS $cid){ $q .= " ('$cid'),"; }
	$q = rtrim($q,",");
	$q .= "; ";		
	$db->query($q);


}	/* fxn */



function getSyncerClassrooms($db){
$dbo=PDBO;
$dbg=PDBG;	

$q = "SELECT crs.id AS trait_id,cond.id AS conduct_id,cr.*,cr.id AS crid,cr.name AS classroom,
		l.name AS level,sxn.name AS section,c.id AS ucid,c.name AS adviser,ctp.ctp,c.account
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		LEFT JOIN (SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active='1'
		) AS cond ON cond.crid = cr.id		
		LEFT JOIN ( SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active='1'
		) AS crs ON crs.crid = cr.id
	WHERE sxn.code <> 'TMP' ORDER BY cr.level_id,sxn.name; ";
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */