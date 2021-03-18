<?php



function getLevel($db,$lvl,$dbg=PDBG){
	$dbo=PDBO;	
	$q=" SELECT id,name,name AS level FROM {$dbo}.`05_levels` WHERE `id` = '$lvl' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */
