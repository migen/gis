<?php


function readTask($db,$id,$dbg=PDBG){
	$dbo=PDBO;	
	$q="SELECT t.*,c.name AS user FROM {$dbg}.tasks AS t 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=t.ucid WHERE t.id='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();

}