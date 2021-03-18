
<?php



function dtlCrByCrs($db,$crsid,$dbg=PDBG,$dbo=DBO){
	$dbo=PDBO;
	$q = "SELECT cr.id AS crid,cr.name AS classroom,cr.name,c.name AS adviser,cr.acid AS acid
		FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id WHERE crs.id = '$crsid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();	

}	/* fxn */


function dtlCriteria($db,$criteria_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = "select * from {$dbo}.`05_criteria` where id = '$criteria_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */


function dtlTeacher($db,$tcid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "select * from {$dbo}.`00_contacts` where `id` = '$tcid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */



function getTrsCriteriaByLevel($db,$lvlid,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT com.weight,cri.id AS criteria_id,cri.id AS cid,cri.code AS code,cri.name AS criteria
	FROM {$dbg}.05_components AS com LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
	WHERE com.level_id = '$lvlid' AND cri.crstype_id = '".CTYPETRAIT."' ORDER BY cri.position,cri.id; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function getClasslistByCrid($db,$crid,$sort=false,$dbo=DBO,$dbg=PDBG){
$dbo=PDBO;
$sort = ($sort)? $sort:"c.name";
$q = "SELECT c.id AS scid,c.name AS student FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id WHERE summ.crid = '$crid' ORDER BY $sort ;";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function getTrsByStudent($db,$qtr,$crsid,$tcid,$scid,$dbo=DBO,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT g.q{$qtr} AS grade,cri.id AS criteria_id
		FROM {$dbo}.`00_contacts` AS `c`
			LEFT JOIN {$dbg}.50_trsgrades AS g ON g.scid = c.id
			LEFT JOIN {$dbg}.`05_summaries` AS `summ`  ON summ.`scid` = c.`id`
			LEFT JOIN {$dbg}.05_classrooms AS `cr`  ON summ.`crid` = cr.`id`						
			LEFT JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
			LEFT JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
			LEFT JOIN {$dbg}.05_components AS `comp` ON (comp.`criteria_id` = cri.`id` AND comp.level_id = cr.level_id) 
		WHERE crs.`id` = '$crsid' AND	g.`tcid` = '$tcid' AND	g.`scid` = '$scid' ORDER BY cri.position,cri.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getTrsAggregates($db,$crsid,$criteria_id,$scid,$qtr,$acid,$advi=true,$dbo,$dbg=PDBG){
	$dbo=PDBO;
	$cond = ($advi)? NULL:" AND g.tcid <> $acid ";
	$q = "SELECT g.id AS gid,'$crsid' AS crsid,g.*,g.q$qtr AS grade
		FROM {$dbg}.50_trsgrades AS g INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id					
		WHERE g.scid = '$scid' AND g.course_id = '$crsid' AND g.criteria_id = '$criteria_id' 
			$cond ORDER BY g.tcid ASC LIMIT 100; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function getTeachersByCrid($db,$crid,$acid,$advi=true,$dbo=DBO,$dbg=PDBG){
	$dbo=PDBO;
	/* order by c.id same in tally trs  */
	$cond = ($advi)? NULL:" AND crs.tcid <> $acid ";
	$q = " SELECT c.id AS tcid,c.name AS teacher,crs.name AS course
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE crs.crid = '$crid' $cond GROUP BY c.id; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function getTrsTeachersByCrid($db,$crsid,$crid,$acid,$advi=true,$dbo=DBO,$dbg=PDBG){	
	$dbo=PDBO;
	/* order by c.id same in tally trs  */
	$cond = ($advi)? NULL:" AND crs.tcid <> $acid ";

	$q = "SELECT c.id AS tcid,c.name AS teacher,crs.name AS course,crs.label
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			INNER JOIN (
				SELECT 
					g.tcid,c.name AS teacher	
				FROM {$dbg}.50_trsgrades AS g	
					INNER JOIN {$dbo}.`00_contacts` AS c ON g.tcid = c.id
				WHERE g.course_id='$crsid' GROUP BY c.id			
			) AS b ON c.id = b.tcid
		WHERE crs.crid = '$crid' $cond GROUP BY c.id ORDER BY tcid ASC; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function trsTeachersByCrid($db,$crsid,$crid,$dbg=PDBG){
	$dbo=PDBO;		
	/* order by c.id same in tally trs  */
	// $cond = ($advi)? NULL:" AND crs.tcid <> $acid ";
	$cond=NULL;

	$q="SELECT c.id AS tcid,c.name AS teacher,crs.name AS course,crs.label
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			INNER JOIN (
				SELECT 
					g.tcid,c.name AS teacher	
				FROM {$dbg}.50_trsgrades AS g	
					INNER JOIN {$dbo}.`00_contacts` AS c ON g.tcid = c.id
				WHERE g.course_id='$crsid'
				GROUP BY c.id			
			) AS b ON c.id = b.tcid
		WHERE crs.crid = '$crid' $cond GROUP BY c.id ORDER BY tcid ASC; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function getTrsMatrix($db,$crsid,$criteria_id,$scid,$qtr,$acid,$advi=true,$dbo,$dbg){
	$dbo=PDBO;
	$cond = ($advi)? NULL:" AND g.tcid <> $acid ";
	$q = "SELECT g.id AS gid,'$crsid' AS crsid,g.*,g.q$qtr AS grade
		FROM {$dbg}.50_trsgrades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id					
		WHERE g.scid = '$scid' AND g.course_id = '$crsid'
			AND g.criteria_id = '$criteria_id' 
			$cond ORDER BY g.tcid ASC LIMIT 100; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */


function getStudentTrsMatrix($db,$dbg,$sy,$qtr,$crs,$scid){
$dbo=PDBO;
$q=" SELECT g.tcid,AVG(g.q{$qtr}) AS ave FROM {$dbg}.50_trsgrades AS g 
	WHERE g.course_id='$crs' AND g.scid='$scid'
	GROUP BY g.tcid ORDER BY g.tcid; ";

$sth=$db->querysoc($q);
return $sth->fetchAll();


} /* fxn */



function deleteTrstally($db,$tcids,$trstcids,$crs,$cri,$scid){
$dbo=PDBO;$dbg=PDBG;
$ix = array_diff($trstcids,$tcids);
$q="";
foreach($ix AS $tcid){
	$q.="DELETE FROM {$dbg}.50_trsgrades WHERE course_id='$crs' AND criteria_id='$cri' AND scid='$scid' 
		AND tcid='$tcid' LIMIT 1; ";
}
$db->query($q);

}	/* fxn */



function addTrstally($db,$tcids,$trstcids,$crs,$cri,$scid){
$dbo=PDBO;
$dbg=PDBG;
$ix = array_diff($tcids,$trstcids);
$q="INSERT INTO {$dbg}.50_trsgrades(`course_id`,`criteria_id`,`scid`,`tcid`)VALUES ";
foreach($ix AS $tcid){ $q.="('$crs','$cri','$scid','$tcid'),"; }
$q = rtrim($q,",");$q .= ";";
$db->query($q);

}	/* fxn */

function trsgradesCriteria($db,$crs,$cri,$scid){
$dbo=PDBO;$dbg=PDBG;
$q="
SELECT g.*,g.id AS trsid,c.name AS teacher
FROM {$dbg}.50_trsgrades AS g
LEFT JOIN {$dbo}.`00_contacts` AS c ON g.tcid=c.id
WHERE g.course_id='$crs' AND g.criteria_id='$cri' AND g.scid='$scid'
ORDER BY g.tcid ASC
";
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function getTrsCrsByCrid($db,$crid,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT crs.id AS crs,crs.name,cr.name AS classroom FROM {$dbg}.05_courses AS crs 
LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
WHERE crs.crstype_id='2' AND crs.crid='$crid' LIMIT 1;";
$sth=$db->querysoc($q);
return $sth->fetch();

}	/* fxn */

function scidBasic($db,$scid,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT c.name,c.name AS student,cr.name AS classroom FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
WHERE c.`id`='$scid' LIMIT 1; ";
$s=$db->querysoc($q);
return $s->fetch();
}	/* fxn */




