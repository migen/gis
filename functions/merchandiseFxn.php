<?php


function getMerchandiseByType($db,$dbg,$id){
	$dbo=PDBO;
	$q="SELECT pr.*,pt.name AS prodtype
		FROM {$dbg}.00_products AS pr
		INNER JOIN {$dbg}.00_prodtypes AS pt ON pt.id=pr.prodtype_id
		WHERE pr.prodtype_id=$id ORDER BY pr.name; ";
	debug("merchandiseFxn: ".$q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
}	/* fxn */