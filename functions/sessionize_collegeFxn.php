<?php


function sessionizeCollegeSettings($db,$dbg=PDBG){		
	$dbo=PDBO;
	unset($_SESSION['college']);
	$q=" SELECT name,value FROM {$dbg}.01_settings ; ";
	$sth=$db->querysoc($q);$rows=$sth->fetchAll();
	foreach($rows AS $row){ $k=$row['name'];$v=$row['value'];$_SESSION['college'][$k]=$v; }			
}  /* fxn */

