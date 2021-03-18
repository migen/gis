<?php

function feecode_id($db,$feecode,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT id FROM {$dbo}.`03_feetypes` WHERE `code` = '$feecode' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['id'];
}	/* fxn */


function fees($db,$lvl,$num,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT l.name AS level,f.name AS feetype,t.label,td.id AS tdid,td.*,f.name AS fee
		FROM {$dbg}.03_tdetails AS td
			INNER JOIN {$dbo}.`03_tuitions` AS t ON (td.level_id = t.level_id AND td.num = t.num)
			INNER JOIN {$dbo}.`05_levels` AS l ON td.level_id = l.id
			INNER JOIN {$dbo}.`03_feetypes` AS f ON td.feetype_id = f.id
		WHERE t.level_id = '$lvl' AND t.num = '$num' ORDER BY f.name;";
	debug($q,'assessmentFxn: fees');	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */


function getOrdinal($num){
	switch($num){
		case 1: $ordinalnum = "1st"; break;
		case 2: $ordinalnum = "2nd"; break;
		case 3: $ordinalnum = "3rd"; break;
		default: $ordinalnum = $num."th"; break;	
	}
	return $ordinalnum;
}	/* fxn */


function advancePayments($db,$sy,$scid){	
	$where=" WHERE p.scid='$scid' ";	
	$nsy=$sy+1;
	$dbo=PDBO;$ndbm=VCPREFIX.$nsy.US.DBG;$ndbg=VCPREFIX.$nsy.US.DBG;
	$q=" SELECT p.*,p.id AS payid,sc.name AS student,
			ft.name AS feetype,pt.name AS paytype
		FROM {$ndbg}.30_payments AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$ndbm}.03_feetypes AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$ndbm}.03_paytypes AS pt ON p.paytype_id = pt.id $where ; ";
	debug($q,'advances: advancePayments');				
	$sth = $db->query($q);
	$data['advpays'] = ($sth)? $sth->fetchAll():array();	/* enrol */
	$data['num_advpays']=count($data['advpays']);	
	return $data;

}	/* fxn */



function feepayments($db,$dbg,$scid,$feeid){
	$dbo=PDBO;
	$q = "SELECT * FROM {$dbo}.30_payments WHERE `scid` = '$scid' AND `feetype_id` = '$feeid'; ";
	debug($q,'assessmentFxn: feepayments');	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();	
	return $rows;

}	/* fxn */

