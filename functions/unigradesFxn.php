<?php

function getCourseUnigrades($db,$crs,$sem,$dbg=PDBG,$order=NULL){
	if(!isset($order)){ $order=$_SESSION['settings']['classlist_order']; }		
	$dbo=PDBO;
	$q="SELECT g.id AS gid,g.*,c.code AS studcode,c.name AS student,c.is_male
		FROM {$dbg}.10_grades AS g
		INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid=c.id
		WHERE g.course_id='$crs' AND g.semester='$sem'
		ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
} 	/* fxn */	

