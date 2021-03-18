<?php


 function purgeEnrollment($db,$dbg,$sy){
	$dbo=PDBO;
	$q="DELETE e,summ FROM {$dbo}.05_enrollments AS e 
		INNER JOIN {$dbg}.05_summaries AS summ ON e.scid=summ.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.section_id < 3; ";pr($q);
	$sth=$db->query($q);
	echo ($sth)? "purge 1 success":"purge 1 fail";

	/* crid less than 1 OR crid IS NULL */
	$q="DELETE FROM {$dbo}.05_enrollments WHERE crid <1; ";pr($q);
	$sth=$db->query($q);
	echo ($sth)? "purge 3 success":"purge 3 fail";

	/* crid is null */
	$q="DELETE FROM {$dbo}.05_enrollments WHERE crid IS NULL; ";pr($q);
	$sth=$db->query($q);
	echo ($sth)? "purge 5 success":"purge 5 fail";	
	
}	/* fxn */


function syncEnrollment($db,$dbg,$sy){
	$dbo=PDBO;
	$q="SELECT scid,crid FROM {$dbg}.05_summaries ORDER BY scid;";
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');
	
	$q="SELECT scid FROM {$dbo}.05_enrollments WHERE sy=$sy ORDER BY scid;";
	$sth=$db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'scid');	

	$ix=array_diff($ar,$br);
	$num_ix=count($ix);
	if($num_ix<10){ pr($ix); }
	pr($num_ix);
		
	/* 1 */	
	$q="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES";
	foreach($ix AS $scid){ $q.="($sy,$scid),";	}
	$q=rtrim($q,",");$q.=";";	
	if($num_ix<10){ pr($q); }
	if($num_ix){
		$sth=$db->querysoc($q);
		echo ($sth)? "insert success":"insert fail";		
	}

	/* 2 */
	$q="UPDATE {$dbo}.05_enrollments AS e 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=e.scid 
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
		SET e.crid=summ.crid,
			e.acid=cr.acid,e.classroom=cr.name,
			e.lvl=cr.level_id,e.sxn=cr.section_id
		WHERE e.sy=$sy;";
	pr($q);
	$sth=$db->querysoc($q);
	echo ($sth)? "update success":"update fail";
	
	
}	/* fxn */


function getNumEnrollments($db,$sy){
	$dbo=PDBO;$q="SELECT count(id) AS `num` FROM {$dbo}.`05_enrollments` WHERE sy=$sy;";
	$sth=$db->querysoc($q);$row = $sth->fetch();pr($q);
	return $row['num'];		
}	/* fxn */
