<?php



function readInfo($db,$id){
	$dbo=PDBO;
	$q="SELECT i.*,c.name AS user,t.name AS infotype FROM {$dbo}.info AS i
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=i.ucid 
			LEFT JOIN {$dbo}.infotypes AS t ON t.id=i.infotype_id WHERE i.id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();

}
