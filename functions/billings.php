<?php


function getBillingById($db,$id){
$dbo=PDBO;
$q="
	SELECT b.*,t.name AS jobtype
	FROM {$dbo}.billings AS b 
	LEFT JOIN {$dbo}.jobtypes AS t ON b.jobtype_id=t.id
	WHERE b.id='$id' LIMIT 1;
";

$sth=$db->querysoc($q);
return $sth->fetch();

}