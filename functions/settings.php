<?php



function getSettings($db,$dbg=PDBG){	
	$dbo=PDBO;
	$q = "SELECT * FROM {$dbo}.`00_settings` ORDER BY label; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll(); 				
}	/* fxn */

