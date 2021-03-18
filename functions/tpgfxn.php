<?php




function tpgfxn($db,$dbg,$lid,$crid,$crsid,$sy,$qtr){
	$dbo=PDBO;
	/* lid-crid-crsId-sy-qtr */		
	$q = " SELECT sum.scid AS cid 
			FROM {$dbg}.05_summaries AS sum
				INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		WHERE sum.`crid` = '$crid'; ";	
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'cid');	
	$q = " SELECT `scid` AS `cid` FROM {$dbg}.50_grades 
		WHERE `course_id` = '$crsid' GROUP BY `scid`; ";
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'cid');
	
	$ix = array_diff($ar,$br);
	return $ix;

}	/* fxn */

