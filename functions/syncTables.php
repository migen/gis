<?php


function syncTable($db,$dbtable,$field="contact_id"){
	// field contact_id = ctp,photos,
	$dbo=PDBO;
	/* 1 contacts */		
	$q=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id`=1; ";			
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'scid');	
	
	/* 2 table with scid or contact_id */		
	$q = "SELECT `$field` AS `scid` FROM {$dbtable};";		
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'scid');

	/* 3 */
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbtable}(`$field`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	$db->query($q);		
	
	
}	/* fxn */


function syncTableCollege($db,$dbtable,$field="contact_id"){
	// field contact_id = ctp,photos,
	$dbo=PDBO;
	/* 1 contacts */		
	$q=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id`=8; ";			
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'scid');	
	
	/* 2 table with scid or contact_id */		
	$q = "SELECT `$field` AS `scid` FROM {$dbtable};";		
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'scid');

	/* 3 */
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbtable}(`$field`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	$db->query($q);		
	
	
}	/* fxn */

