<?php

function payBill($db,$ecid,$ucid,$post,$payer){
	$dbo=PDBO;
	$dbg=PDBG;
	$amount=$post['amount'];
	$date=$post['date'];
	$orno=trim($post['orno']);
	$feetype_id=$post['feetype_id'];
	$paytype_id=$post['paytype_id'];
	$bank_id=$post['bank_id'];
	$reference=$post['reference'];
	
if($ucid){
	$q="INSERT INTO {$dbo}.30_payments_bills(`scid`,`feetype_id`,`amount`,`date`,`orno`,`ecid`,`paytype_id`,`bank_id`,`reference`) VALUES ('$ucid','$feetype_id','$amount','$date','$orno','$ecid','$paytype_id','$bank_id','$reference');";	
} else {
	$q="INSERT INTO {$dbo}.30_payments_bills(`scid`,`payer`,`feetype_id`,`amount`,`date`,`orno`,`ecid`,`paytype_id`,`bank_id`,
	`reference`) VALUES ('0','$payer','$feetype_id','$amount','$date','$orno','$ecid','$paytype_id','$bank_id','$reference');";	
}
	// pr($q);exit;
	$db->query($q);

	/* 2 */
	$q = "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '$ecid' LIMIT 1;";
	$db->query($q);
	$_SESSION['orno'] = $orno; 			

}	/* fxn */
