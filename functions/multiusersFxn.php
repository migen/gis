<?php

function getMultiUsers($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT uc.id AS ucid,uc.name,uc.is_active,pc.id AS pcid,pc.id AS pcid,pc.code,
			t.name AS title,r.name AS role
		FROM {$dbo}.`00_contacts` AS uc
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON uc.parent_id = pc.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON uc.title_id = t.id
			LEFT JOIN {$dbo}.`00_roles` AS r ON uc.role_id = r.id		WHERE uc.parent_id <> 1
		GROUP BY uc.`parent_id`
		HAVING COUNT(uc.parent_id) > 1; ";
	$sth  = $db->querysoc($q);
	$rows = $sth->fetchAll();
	return $rows;

}	/* fxn */


function getMultis($db,$pcid,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT uc.parent_id AS pcid,uc.id AS ucid,uc.account,uc.is_active,uc.is_cleared, 
		pc.is_org,uc.title_id,uc.role_id,uc.privilege_id,uc.name,uc.code,
		t.name AS title,r.name AS role,ctp.ctp
	FROM {$dbo}.`00_contacts` AS uc
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON uc.parent_id = pc.id
		LEFT JOIN {$dbo}.`00_titles` AS t ON uc.title_id = t.id
		LEFT JOIN {$dbo}.`00_roles` AS r ON uc.role_id = r.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON uc.id = ctp.contact_id
	WHERE uc.parent_id = '$pcid' ;	";

$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */

