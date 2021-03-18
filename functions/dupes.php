<?php

function getStudcavsRow($db,$scid,$dbg=PDBG){
	$dbo=PDBO;
	$q="
		SELECT
			c.id AS scid,c.name AS student,crs.name AS course,summ.crid,
			crs.id AS crs
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbg}.05_courses AS crs ON cr.id=crs.crid
		WHERE c.id='$scid'
			AND crs.crstype_id='".CTYPETRAIT."'		
	";


	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	
	
}	