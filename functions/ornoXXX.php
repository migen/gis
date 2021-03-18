<?php



function posLastOrno($db){
	$dbg=PDBG;$dbo=PDBO;	
	if(!isset($_SESSION['last_orno'])){ $row = maxOrno($db,$dbg); $_SESSION['last_orno'] = $row['max_orno']; }
	if(!isset($_SESSION['last_posid'])){ $_SESSION['last_posid'] = lastId($db,"{$dbo}.`30_pos`"); }	
	$data['last_orno'] = $_SESSION['last_orno']; 
	$data['last_posid'] = $_SESSION['last_posid']; 
	return $data;

}	/* fxn */


function lastOrno($db,$ecid){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbo}.`03_orbooklets` WHERE ecid = '$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	if(empty($row)){
		$q = " INSERT INTO {$dbo}.`03_orbooklets` (`ecid`) VALUES('$ecid'); ";
		$db->query($q);	
	}	
	return $row['orno'];
}	/* fxn */

function cancelOrno($db,$dbg,$orno,$more){
	$dbo=PDBO;
	$date = isset($more['date'])? $more['date']:$_SESSION['today'];
	$ecid = isset($more['ecid'])? $more['ecid']:$_SESSION['ucid'];
	$remarks = isset($more['remarks'])? $more['remarks']:NULL;

	$q = "INSERT INTO {$dbg}.ornos (`date`,`is_void`,`ecid`,`orno`,`remarks`) VALUES 
		('$date','1','$ecid','$orno','$remarks');";	
	$_SESSION['q'] = $q;
	$db->query($q);
		
}	/* fxn */


function getMaxOrno($db,$dbg,$table){
	$dbo=PDBO;
	$q="SELECT orno FROM {$dbg}.$table ORDER BY orno DESC LIMIT 1; ";
	debug("ornoFxn: $q");
	$sth=$db->querysoc($q);
	$row = $sth->fetch();
	return $row['orno'];
}	/* fxn */

function maxOrno($db,$dbg){
	$dbo=PDBO;
	$abc = array();
	$data['last_orno_payments'] = $abc[] = getMaxOrno($db,$dbg,'30_payments');
	$data['max_orno'] = max($abc);
	return $data;	
	
}	/* fxn */
