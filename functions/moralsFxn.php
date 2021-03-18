<?php


function getStudentsAllForSyncing($db){
	$dbo=PDBO;$dbg=PDBG;
	$q=" SELECT summ.scid FROM {$dbg}.05_summaries AS summ INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.`section_id`>2; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

function getAwardeesAllForSyncing($db){
	$dbo=PDBO;$dbg=PDBG;
	$q=" SELECT a.scid FROM {$dbg}.05_awardees AS a; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function syncAwardeesAll($db){
	$dbo=PDBO;
	$dbg=PDBG;
	$a=getStudentsAllForSyncing($db);
	$ar = buildArray($a, 'scid');
	$b=getAwardeesAllForSyncing($db);
	$br = buildArray($b, 'scid');
	$ix = array_diff($ar, $br);	
	if(!empty($ix)){
		$q="INSERT INTO {$dbg}.05_awardees(`scid`)VALUES";
		foreach($ix AS $scid){ $q.="('$scid'),"; } $q=rtrim($q,",");$q.=";";
		$sth=$db->query($q); echo ($sth)? "Synced Awardees All":NULL;		
	}

}	/* fxn */


