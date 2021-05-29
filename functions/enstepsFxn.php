<?php


function getStudentEnsteps($db,$sy,$scid){
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q="
		SELECT c.id AS scid,c.code AS studcode,c.name AS studname,c.enstep,cr.name AS classroom,
			s.*,s.id AS step_id,s.type AS step_type
		FROM {$dbo}.00_contacts AS c 
		LEFT JOIN {$dbo}.05_steps AS s ON (c.id=s.scid && s.type='enrollment')
		LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		WHERE c.id=$scid LIMIT 1;			
	";
	debug($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;


} 	/* fxn */

