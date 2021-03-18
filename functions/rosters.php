<?php

function tmpcrid($db,$dbg,$lvl,$crid){
	$dbo=PDBO;
	$q="SELECT id AS tmpcrid FROM {$dbg}.05_classrooms WHERE `level_id`=$lvl AND `section_id`=1 LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	return $row['tmpcrid'];
}	/* fxn */

function outcrid($db,$dbg,$lvl,$crid){
	$dbo=PDBO;
	$q="SELECT id AS outcrid FROM {$dbg}.05_classrooms WHERE `level_id`=$lvl AND `section_id`=2 LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	return $row['outcrid'];
}	/* fxn */


function rosterList($db,$dbg,$crid){
	$dbo=PDBO;
	$q = "SELECT c.id AS scid,c.code,c.name AS student,c.position,c.is_active
		FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		WHERE summ.crid='$crid' ORDER BY c.name; ";	
	debug("rostersFxn: rosterList - ".$q);
	if(isset($_GET['debug'])){ $_SESSION['q']=$q; } 	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}


function sxnThisQuery($db,$sy,$scid,$crid){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="";
	$q.="UPDATE {$dbo}.05_enrollments SET `crid`=$crid WHERE sy=$sy AND `scid`=$scid LIMIT 1;	";	
	$q.="UPDATE {$dbg}.05_summaries SET prevcrid=crid,`crid`=$crid WHERE `scid`=$scid LIMIT 1;	";	
	return $q;
	

}	/* fxn */


function rosterSummaries($db,$sy,$crid){
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT en.id AS enid,en.crid AS encrid,c.sy,c.code,c.name,summ.crid,c.crid AS contcrid,c.is_active,summ.scid
	FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id
		LEFT JOIN {$dbo}.`05_enrollments` AS en ON (en.sy=$sy AND c.id=en.scid)
	WHERE summ.crid='$crid' ORDER BY c.is_male DESC,c.name;";

// LEFT JOIN {$dbo}.`05_enrollments` AS en ON (en.sy=$sy AND c.id=en.scid)	
// pr($q);
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */
