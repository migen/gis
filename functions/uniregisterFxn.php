<?php

function initUnistudent($db,$scid,$dbg=PDBG){	
	$dbo=PDBO;
	$last_id=lastId($db,"{$dbg}.01_summaries");$id=$last_id+1;
	$q="INSERT INTO {$dbg}.01_summaries(id,scid)VALUES($id,$scid); ";
	$sth=$db->query($q);
	return ($sth)? true:false;
}	/* fxn */


function getStudentForCollegeRegistration($db,$scid,$dbg=PDBG){	
	$dbo=PDBO;
	$q="SELECT c.id AS scid,c.id,c.code AS studcode,c.name AS student,c.is_active,cr.name AS classroom,c.role_id,
				summ.*,summ.scid AS summscid,summ.crid AS summcrid
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.01_classrooms AS cr ON summ.crid=cr.id 
		WHERE c.id=$scid LIMIT 1;
	";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */


