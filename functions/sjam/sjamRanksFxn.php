<?php



function getSjamLevelRanks($db,$dbg,$dbo,$lvl,$qtr){	
	$q="SELECT 
			sumx.rank_level_ave_q{$qtr} AS rank,	
			sumx.rank_level_ave_q{$qtr} AS dbrank,	
			summ.scid,c.name AS `student`,
			summ.`ave_q$qtr` AS `genave`,
			summ.`conduct_q$qtr` AS `conduct`,
			cr.name AS section
		FROM {$dbo}.`00_contacts` AS `c`
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_summext AS sumx ON summ.scid=sumx.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.level_id='$lvl' AND summ.`conduct_q$qtr`>=90
		ORDER BY summ.`ave_q$qtr` DESC; ";
	debug($q);
	$sth=$db->querysoc($q);
	$d['rows']=$sth->fetchAll();

	$d['count']=$sth->rowCount();
	// pr($d);
	return $d;
	
}	/* fxn */
