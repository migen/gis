<?php


function justTsum($db,$scid,$dbg){
	$dbo=PDBO;
	$q = "SELECT t.* FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (t.level_id = cr.level_id && t.num = cr.num)";
	$q .= " WHERE c.id 	= '$scid'; ";
	debug($q,"addons: justTsum");
	$sth = $db->querysoc($q);
	return $sth->fetch();


}	/* fxn */