<?php



function getTerminal($db,$ip,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT id FROM {$dbo}.terminals WHERE ip = '$ip' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['id'];
	
}	/* fxn */


function clearTerminal($db,$tid,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " UPDATE {$dbo}.terminals SET `ucid` = '0', `acn` = '0' WHERE `id` = '$tid' LIMIT 1;  ";
	$db->query($q);
}	/* fxn */
