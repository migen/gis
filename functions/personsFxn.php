<?php

function getPerson($db,$pcid){
$dbo=PDBO;$dbg=PDBG;
$q = "SELECT ctp.*,
		c.*,c.name AS person,
		s.*,p.*,r.name AS role,t.name AS title		
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
		LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
	WHERE c.id = '$pcid'; ";
$sth = $db->querysoc($q);
debug($q,"personsFxn: getPerson.");
return $sth->fetch();

}	/* fxn */
