<?php


function updateConduct($db,$post,$qtr){
	$dbo=PDBO;
	$dbg=PDBG;
	$scid=$post['scid'];$gid=$post['gid'];
	$adjusted=$post['adjusted'];$is_awardee=$post['is_awardee'];	
	$q="";
	$q.="UPDATE {$dbg}.`50_grades` SET `q{$qtr}`='$adjusted' WHERE `id`='$gid' LIMIT 1; ";
	$q.="UPDATE {$dbg}.05_summaries SET conduct_q{$qtr} ='$adjusted' WHERE `scid`='$scid' LIMIT 1;  ";
	$q.="UPDATE {$dbg}.05_awardees SET `is_conduct_awardee_q{$qtr}` ='$is_awardee' WHERE `scid`='$scid' LIMIT 1;  ";						
	return $q;
}	/* fxn */



function getClasslistForSyncing($db,$crid){
	$dbo=PDBO;$dbg=PDBG;
	$q=" SELECT scid FROM {$dbg}.05_summaries WHERE `crid`='$crid'; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

function getAwardeesForSyncing($db,$crid){
	$dbo=PDBO;$dbg=PDBG;
	$q=" SELECT a.scid FROM {$dbg}.05_awardees AS a INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=a.scid
		WHERE summ.`crid`='$crid'; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function syncAwardees($db,$crid){
	$dbg=PDBG;
	$dbo=PDBO;	
	$a=getClasslistForSyncing($db,$crid);
	$ar = buildArray($a, 'scid');
	$b=getAwardeesForSyncing($db,$crid);
	$br = buildArray($b, 'scid');
	$ix = array_diff($ar, $br);	
	if(!empty($ix)){
		$q="INSERT INTO {$dbg}.05_awardees(`scid`)VALUES";
		foreach($ix AS $scid){ $q.="('$scid'),"; } $q=rtrim($q,",");$q.=";";
		$sth=$db->query($q); echo ($sth)? "Synced":NULL;		
	}

}	/* fxn */

function getConductDetails($db,$dbg,$crid){	
	$dbo=PDBO;
	$q=" SELECT crs.id AS course_id,crs.name,crs.crid,cr.level_id,cr.acid,cr.name AS classroom,c.name AS adviser,cr.is_free,
			aq.conduct_q1,aq.conduct_q2,aq.conduct_q3,aq.conduct_q4
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		LEFT JOIN {$dbg}.`05_advisers_quarters` AS aq ON aq.crid=cr.id
		WHERE crs.crstype_id='".CTYPECONDUCT."' AND crs.crid='$crid'; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();

}	/* fxn */


function getClassroomConductDetails($db,$dbg,$crid){
	$dbo=PDBO;
	$q="
		SELECT cr.id,cr.name,cr.acid,c.name AS adviser,crs.id AS cdtcrs
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		WHERE cr.id ='$crid' AND crs.crstype_id='".CTYPECONDUCT."' LIMIT 1;
	";
	debug($q,"CdtFxn: getClassroomConductDetails");
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */


function getClasslistWithCdtcrsGrade($db,$dbg,$crid,$cdtcrs,$qtr,$order){
	$dbo=PDBO;
	$q="
		SELECT 
			c.id AS scid,c.code AS studcode,c.name AS student,g.`q{$qtr}` AS grade,g.id AS gid
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.50_grades AS g ON g.scid=c.id
		WHERE summ.crid ='$crid' AND g.course_id='$cdtcrs' ORDER BY $order;
	";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */

function getCdtgrades($db,$dbg,$crid,$tcid,$order,$qtr){
	$dbo=PDBO;
	$q=" SELECT 
			summ.scid,g.q{$qtr} AS grade,g.id AS gid
		FROM {$dbg}.50_cdtgrades AS g
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=g.scid
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		WHERE summ.crid ='$crid' AND g.tcid='$tcid' ORDER BY $order;
	";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function syncCdtgrades($db,$dbg,$crid,$tcid,$cdtcrs,$qtr,$order){
	/* 1 - IMPT order, classlist more than grades */
	// $a=getClasslist($db,$dbg,$crid,$order);
	$dbo=PDBO;	
	$a=getClasslistWithCdtcrsGrade($db,$dbg,$crid,$cdtcrs,$qtr,$order);
	$ar = buildArray($a, 'scid');

	$b=getCdtgrades($db,$dbg,$crid,$tcid,$order,$qtr);
	$br = buildArray($b, 'scid');

	$ix = array_diff($ar, $br);
	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_cdtgrades(`scid`,`tcid`) VALUES ";
		foreach($ix AS $scid){ $q .= " ('$scid','$tcid'), "; }
		$q = rtrim($q,", ");$q .= ";";
		$db->query($q);
		
	}	/* ix */
	

}	/* fxn */

function getTeachersByClassroom($db,$dbg,$crid){
	$dbo=PDBO;
	$q=" SELECT c.name,crs.tcid
	FROM {$dbg}.`05_courses` AS crs 
	INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	WHERE crs.crid='$crid' GROUP BY crs.tcid ORDER BY c.name; ";
	debug($q,"cdtFxn: getTeachersByClassroom");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



