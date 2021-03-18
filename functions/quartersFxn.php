<?php

function getQuarterMonths($db,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT * from {$dbo}.`05_months_quarters` ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

