<?php


function syncStudStep($db,$scid,$type){
	$dbo=PDBO;
	$q="SELECT id FROM {$dbo}.05_steps WHERE scid=$scid AND type='$type' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	
	if(empty($row)){
		$q="INSERT INTO {$dbo}.05_steps(scid,type)VALUES($scid,'$type'); ";
		$sth=$db->query($q);
		// pr($q);echo $sth? "insert ok":"insert fail";		
	}
	
}	/* fxn */
