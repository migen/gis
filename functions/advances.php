<?php


function advancePay($db,$scid,$post,$dbg=PDBG){	
	$dbo=PDBO;
	$ecid=$_SESSION['ucid'];
	$feetype_id=$_SESSION['tfeeid'];
	$paytype_id=$post['paytype_id'];
	$orno = trim($post['orno']);		
	$reference=$post['reference'];
	$date=$post['date'];
	$pointer=$post['pointer'];
	$amount = str_replace(",","",$post['amount']);		
	$ndbg=VCPREFIX.(DBYR+1).US.DBG;		
	if($amount>0){
		$q="INSERT INTO {$ndbg}.30_payments (`date`,`ecid`,`scid`,`feetype_id`,`paytype_id`,`amount`,`orno`,`reference`,`pointer`) VALUES
		('$date','$ecid','$scid','$feetype_id','$paytype_id','$amount','$orno','$reference','$pointer'); ";
		// pr($q);exit;		
		$db->query($q);
	}	

}	/* fxn */


