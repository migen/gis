<?php

function getPrerequisites($db,$dbg){			
	$dbo=PDBO;
	$q="SELECT pr.*,pr.id AS prid,GROUP_CONCAT(ps.name ORDER BY ps.name SEPARATOR ', ') AS prerequisites,
			s.id AS sub,s.id,s.code,s.name			
		FROM {$dbo}.`05_subjects` AS s	
		LEFT JOIN {$dbg}.01_prerequisites AS pr ON pr.subject_id = s.id
		LEFT JOIN {$dbo}.`05_subjects` AS ps ON pr.parent_id = ps.id
		GROUP BY s.id ORDER BY s.name; ";				
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	return $data;
	
}	/* fxn */



function getSubjects($db,$dbg){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`05_subjects`; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */
