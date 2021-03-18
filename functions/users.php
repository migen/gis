<?php

function syncCdept($db,$cid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT `contact_id` FROM {$dbo}.`88_contacts_departments` WHERE `contact_id` = $cid LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
		
	if(empty($row)){ 
		$q = "INSERT INTO {$dbo}.`88_contacts_departments` (`contact_id`) VALUES ('$cid');  ";
		$_SESSION['q'] = $q;
		$db->query($q);	
	} 
	
}	/* fxn */


function getParentDetails($db,$pcid,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT c.id AS pcid,t.name AS title,ctp.ctp,c.*,cd.*
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON c.id = ctp.contact_id
		LEFT JOIN {$dbo}.`88_contacts_departments` AS cd ON cd.contact_id = c.id
	WHERE c.id = $pcid LIMIT 1; "; 
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function getUsers($db,$pcid,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT c.id AS ucid,c.account,c.is_active,c.is_cleared, 
		c.is_org,c.title_id,c.role_id,c.privilege_id,t.name AS title,ctp.ctp,cd.*
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON c.id = ctp.contact_id
		LEFT JOIN {$dbo}.`88_contacts_departments` AS cd ON cd.contact_id = c.id
	WHERE c.parent_id = '$pcid' AND c.id <> $pcid;"; 
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */

