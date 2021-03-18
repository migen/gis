<?php



function getScidProfile($db,$scid,$with_chinese=false){
	$dbo=PDBO;
	$q="SELECT id,code,name,account,lrn";
	if($with_chinese){ $q.=",chinese_name"; }	
	$q.=" FROM {$dbo}.`00_contacts` WHERE id=$scid LIMIT 1; ";
	echo "pFxn: "; pr($q);
	$sth=$db->querysoc($q);
	// $data['row']=$sth->fetch();
	return $sth->fetch();
	
	
}	/* fxn */

