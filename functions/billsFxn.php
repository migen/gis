<?php




function scidBills($db,$sy,$scid,$fields=NULL){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	
	
	$q = "SELECT p.*,ft.name AS feetype,p.id AS payment_id,pt.name AS paytype,p.id AS pkid
			FROM {$dbo}.30_payments AS p 
			LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
			LEFT JOIN {$dbo}.03_paytypes AS pt ON p.paytype_id=pt.id
			WHERE p.sy=$sy AND p.scid=$scid AND p.in_tuition<>1 ORDER BY p.date DESC; ";
	debug("BillsFxn: scidBills: ".$q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	// $rows=$sth->fetchAll();
	debug($rows);
	// pr($q);pr($rows);
	return $rows;
}	/* fxn */

