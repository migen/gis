<?php


function getCcr($db,$dbg){
	$dbo=PDBO;
	$q="SELECT
			cr.*,cr.id AS crid,l.name AS level,s.name AS section
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		ORDER BY l.id;";
	$sth=$db->querysoc($q);
	$d['rows']=$sth->fetchAll();
	$d['count']=$sth->rowCount();
	return $d;
		
}	/* fxn */

