<?php

function urooms($ucid,$db){
	$dbo=PDBO;
	$q = " SELECT r.name AS room, rc.*, ctc.`id` AS `ctcid`, ctc.name AS ctc 
			FROM {$dbo}.rooms_contacts AS rc 
				LEFT JOIN {$dbo}.rooms AS r ON rc.room_id = r.id
				LEFT JOIN {$dbo}.ctagcategories AS ctc ON r.ctagcategory_id = ctc.id
			WHERE rc.contact_id = $ucid; ";
	$sth = $db->querysoc($q);
	$urooms = $sth->fetchAll();
	
	$_SESSION['urooms'] = $urooms;	
	$uroom_ids = buildArray($urooms,'room_id');
	$_SESSION['uroom_ids'] = $uroom_ids;		
	

}  	/* fxn */

