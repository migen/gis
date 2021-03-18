<?php


function getClasslistCrcards($db,$dbg,$crid){
	$dbo=PDBO;
	$ordercond=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];
	$limitcond=(isset($_GET['limit']))? 'LIMIT '.$_GET['limit']:NULL;
	$q="
		SELECT c.name AS student,c.code AS studcode,c.lrn,summ.*			
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE summ.crid='$crid' ORDER BY $ordercond $limitcond
		
	";
	// pr($q);
	debug("crcardsFxn-getClasslistCrcards: $q ");
	$sth=$db->querysoc($q); 
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
	
}	/* fxn */