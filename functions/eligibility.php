<?php


function syncEligibility($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT c.`id` AS `scid` FROM {$dbo}.`00_contacts` AS c WHERE c.`role_id` = '".RSTUD."' ORDER BY c.`id`;";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'scid');

	$q = " SELECT e.`scid` FROM {$dbg}.eligibility AS e ORDER BY e.`scid`;";
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'scid');

	$ix = array_diff($ar,$br);

	$q = "INSERT INTO {$dbg}.eligibility(`scid`) VALUES ";
	foreach($ix AS $scid){ $q .= "('$scid'),"; }
	$q=rtrim($q,',');
	$q.=";";
	$db->query($q);		

} /* fxn */