<?php


function syncPromotions($db,$dbg,$sy){
	$dbo=PDBO;
	/* 1 */
	$q = " SELECT cr.`id` AS `crid` FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
			WHERE sec.code <> 'TMP' ORDER BY cr.`id` ;				
		; ";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'crid');
	
	/* 2 */
	$q = " SELECT p.`crid` AS `crid` FROM {$dbg}.05_promotions AS p
			INNER JOIN {$dbg}.05_classrooms AS cr ON p.crid = cr.id			
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id			
		WHERE sec.code <> 'TMP'; ";
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'crid');
	
	$ix = array_diff($ar,$br);
	
	$q = " INSERT INTO {$dbg}.05_promotions(`crid`) VALUES  ";
	foreach($ix AS $crid){ $q .= " ('$crid'),"; }
	$q = rtrim($q,",");
	$q .= "; ";		
	$db->query($q);		

}	/* fxn */

