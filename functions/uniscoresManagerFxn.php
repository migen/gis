<?php


function deleteUniscores($db,$dbg,$activity_id){
	$dbo=PDBO;
	$qry = '';
	$q = " DELETE FROM {$dbg}.10_activities where `id`=$activity_id ";
	$r = $db->query($q);
	if(!$r){ pr($q); die('Query failed.'); return false; }		
	debug($q);
	$qry .= $q;

	$q = " DELETE FROM {$dbg}.10_scores WHERE activity_id = '$activity_id' LIMIT 50 ";
	$r = $db->query($q);
	if(!$r){ pr($q); die('Query failed.'); return false; }		
	debug($q);	
	$qry .= $q;
	return true;

}   /* fxn */

