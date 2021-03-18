<?php


function tuition($db,$lvl,$num,$dbg=PDBG){	
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`03_tuitions` WHERE level_id='$lvl' AND num='$num' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function fees($db,$lvl,$num,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT td.*,tf.name AS feetype
		FROM {$dbg}.03_tdetails AS td
		LEFT JOIN {$dbo}.`03_feetypes` AS tf ON tf.id=td.feetype_id
		WHERE level_id='$lvl' AND num='$num'; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



function summ($db,$scid,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT summ.*,c.name AS student,cr.level_id FROM {$dbg}.05_summaries AS summ 
INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
WHERE summ.scid='$scid';";
$sth=$db->querysoc($q);
return $sth->fetch();

} 	/* fxn */


function summary($db,$scid,$dbg){
$dbo=PDBO;
$q="SELECT summ.crid AS summcrid,c.crid AS concrid,c.name AS student
	FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
	WHERE c.id='$scid' LIMIT 1;";
$sth=$db->querysoc($q);
return $sth->fetch();

}	/* fxn */

