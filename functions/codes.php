<?php

/* lookups  */




function getMonthCode($db,$mid,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT code FROM {$dbo}.`05_months_quarters` WHERE `id` = '$mid' LIMIT 1; ";
	$sth	= $db->querysoc($q);
	$row 	= $sth->fetch();
	return $row['code'];	
}	/* fxn */
