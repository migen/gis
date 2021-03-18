<?php

function qryLevelcurrcostVsPocost($db,$prid,$dbg=PDBG){			
	$dbo=PDBO;
	$q="SELECT level_currcost FROM {$dbo}.`03_products` WHERE id=$prid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$qry="";
	if($row['level_currcost']<=0){
		$qry.="UPDATE {$dbo}.`03_products` SET `cost`=`pocost`,`level_currcost`=`level` WHERE id=$prid LIMIT 1; ";
	}	
	return $qry;

}	/* fxn */


function processLevelcurrcostVsPocost($db,$prid,$dbg=PDBG){			
	$dbo=PDBO;
	$q="SELECT level_currcost FROM {$dbo}.`03_products` WHERE id=$prid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if($row['level_currcost']<=0){
		$q="UPDATE {$dbo}.`03_products` SET `cost`=`pocost`,`level_currcost`=`level` WHERE id=$prid LIMIT 1; ";
		$db->query($q);
	}	

}	/* fxn */