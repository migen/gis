<?php


function updateStudenpaymodeQuery($scid,$pmid,$dbg=PDBG){
	$dbo=PDBO;
	$q="UPDATE {$dbg}.03_tsummaries SET `paymode_id`='$pmid' WHERE `scid`='$scid' LIMIT 1; ";
	return $q;
}	/* fxn */

