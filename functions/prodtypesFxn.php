<?php

function getAllProdtypes($db,$dbg){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbg}.00_prodtypes ORDER BY name; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
}	/* fxn */
