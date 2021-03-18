<?php

function xxxgetSchRAR1($db,$sy=DBYR,$dept='gs',$sch=VCFOLDER){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$cond_dept=($dept=='gs')? "l.department_id<=2":"l.department_id>2";	
	$q="SELECT c.code AS studcode,c.name AS student,ar.*,ar.id AS arid,cr.name AS classroom
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbg}.{$sch}_ar_{$sy} AS ar ON ar.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON ar.crid=cr.id
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE $cond_dept AND ar.balance>0
		ORDER BY cr.level_id,cr.section_id,c.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
}	/* fxn */



function getPreviousBalance($db,$sy=DBYR,$dept='gs'){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$prevbal_feeid=3;
	$cond_dept=($dept=='gs')? "l.department_id<=2":"l.department_id>2";	
	$q="SELECT c.code AS studcode,c.name AS student,p.*,p.id AS pkid,cr.name AS classroom
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbo}.30_payables AS p ON p.scid=c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE p.sy=$sy AND p.feetype_id=$prevbal_feeid AND $cond_dept AND p.amount>0
		ORDER BY cr.level_id,cr.section_id,c.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
}	/* fxn */