<?php

function getClassroomPhotos($db,$crid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "
		SELECT
			c.id,c.id AS ucid,c.parent_id AS pcid,
			c.name AS student,
			p.photo
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id = summ.scid
			LEFT JOIN ".DBP.".photos AS p ON p.contact_id = c.id
		WHERE 
			summ.crid = '$crid'
		ORDER BY c.name LIMIT 100;		
	";
	// pr($q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */