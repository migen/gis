<?php

function getGenaveRanks($db,$dbg,$crid,$qtr,$dbo=PDBO,$limitcond=NULL){
$dbo=PDBO;	
$q="SELECT sumx.rank_classroom_q{$qtr} AS classrank,sumx.id AS sumxid, 
		summ.scid,summ.ave_q{$qtr} AS genave,
		c.name AS student,c.code AS studcode
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	LEFT JOIN {$dbg}.05_summext AS sumx ON sumx.scid=c.id
	WHERE summ.crid='$crid' ORDER BY genave DESC $limitcond; ";	
debug($q,"ranksFxn: getLevelRanks");
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */

