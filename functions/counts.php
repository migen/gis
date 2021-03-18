<?php


function countStudents($db,$dbg,$sy,$crid){
$dbo=PDBO;
$q = "SELECT count(sum.scid) AS numrows
	FROM {$dbg}.05_summaries AS sum
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
	WHERE sum.crid = '$crid' ;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */


