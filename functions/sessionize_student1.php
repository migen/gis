<?php


function getStudinfo($db,$sy,$ucid){
	$srid=$_SESSION['srid'];
	if($srid==RSTUD){ $sy=$_SESSION['settings']['sy_grading']; }
	$dbo=PDBO;
	$sy=$_SESSION['year'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;
	$q = "SELECT c.id AS scid,c.code,c.name,c.account,c.is_active,c.remarks,cr.name AS classroom,
			cr.level_id,l.department_id,en.sy AS ensy,en.scid AS enscid,cr.num,
			l.code AS lvlcode,l.subdepartment_id,c.sy_registered,
			cr.level_id AS currlvl,pcr.level_id AS prevlvl			
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy && en.scid=c.id)
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		LEFT JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id		
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE c.id = $ucid LIMIT 1; ";		
	debug($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();		
	// pr($q);
	// pr($row);
	if($_SESSION['settings']['has_axis']){
		$row1=getTotalPreviousBalance($db,$ucid);
		$row=array_merge($row,$row1);	
	}

	return $row;
	
	
}	/* fxn */


function getTotalPreviousBalance($db,$ucid){
	$dbo=PDBO;
	$q="SELECT sum(amount) AS balance,scid
		FROM {$dbo}.30_payables WHERE scid=$ucid 
			AND feetype_id=3 AND is_paid=0
		GROUP BY scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	
	
	
	if(empty($row)){ $row['balance']=0; }
	$_SESSION['student']['balance']=$row['balance'];
	
	
	
	return $row;
}	/* fxn */


function getPayables($db,$ucid,$sy=DBYR,$feetype_id=false){
	$cond="";
	if($sy){ $cond.=" AND p.sy=$sy"; }
	if($feetype_id){ $cond.=" AND p.feetype_id=$feetype_id"; }
	$dbo=PDBO;
	$q="SELECT p.*,f.name AS feetype,p.id AS pkid
		FROM {$dbo}.30_payables AS p
		INNER JOIN {$dbo}.03_feetypes AS f ON p.feetype_id=f.id
		WHERE p.scid=$ucid $cond 
		ORDER BY p.sy DESC,f.name;";
	debug("sessionize_student-getPayables: ".$q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
}	/* fxn */


function sessionizeStudinfo($db,$ucid=NULL,$sy=DBYR){
	$ucid=isset($ucid)? $ucid:$_SESSION['ucid'];
	return getStudinfo($db,$sy,$ucid);	

}	/* fxn */

