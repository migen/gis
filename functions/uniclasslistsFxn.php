<?php



function getUniclasslist($db,$dbg,$crid,$lvl,$order=NULL){
	$dbo=PDBO;
	if(!isset($order)){ $order=$_SESSION['settings']['classlist_order']; }		
	$q="SELECT c.is_active,c.code AS studcode,c.name AS student,
			summ.scid,summ.crid,summ.level_id
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		WHERE summ.crid='$crid' AND summ.level_id=$lvl
		ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);	
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
} 	/* fxn */	

function getUnicourselist($db,$crs,$sem,$dbg,$order=NULL){
	$dbo=PDBO;
	if(!isset($order)){ $order=$_SESSION['settings']['classlist_order']; }		
	$q="SELECT g.id AS gid,c.code AS studcode,c.name AS student,g.*
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.10_grades AS g ON g.scid=c.id
		WHERE g.course_id='$crs' AND g.semester='$sem'
		ORDER BY $order; ";	
	debug($q);
	$sth=$db->querysoc($q);	
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
} 	/* fxn */	

