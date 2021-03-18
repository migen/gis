<?php


function ordata($db,$date){
$dbo=PDBO;
$dbg=PDBG;
$q="SELECT orno FROM {$dbo}.30_payments WHERE `date`='$date' ORDER BY orno ASC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$start1=$row['orno'];

$q="SELECT orno FROM {$dbo}.30_payments_bills WHERE `date`='$date' ORDER BY orno ASC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$start2=$row['orno'];
$data['or_first']=min($start1,$start2);

$q="SELECT orno FROM {$dbo}.30_payments WHERE `date`='$date' ORDER BY orno DESC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$end1=$row['orno'];

$q="SELECT orno FROM {$dbo}.30_payments_bills WHERE `date`='$date' ORDER BY orno DESC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$end2=$row['orno'];
$data['or_last']=max($end1,$end2);

return $data;

}	/* fxn */



function payTotal($db,$ecid,$date,$paytype_id,$has_ndbg,$has_pdbg=0){
$dbo=PDBO;
$dbg=PDBG;
$pdbg=VCPREFIX.(DBYR-1).US.DBG;$ndbg=VCPREFIX.(DBYR+1).US.DBG;

$q = "SELECT sum(amount) AS total FROM {$dbo}.30_payments WHERE `paytype_id` = '$paytype_id' AND `date`='$date'
	AND `ecid`='$ecid' LIMIT 1; ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$sum1=$row['total'];
debug($q,"paytTotal ");	
$q = "SELECT sum(amount) AS total FROM {$dbo}.30_payments_bills WHERE `paytype_id` = '$paytype_id' AND `date`='$date' 
	AND `ecid`='$ecid' LIMIT 1; ";
debug($q,"paytTotal ");		
$sth = $db->querysoc($q);
$row = $sth->fetch();
$sum2=$row['total'];

if($has_ndbg){
	$q = "SELECT sum(amount) AS total FROM {$ndbg}.30_payments WHERE `paytype_id` = '$paytype_id' AND `date`='$date' 
		AND `ecid`='$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$sum3=$row['total'];
	debug($q,"paytTotal ");	

	$q = "SELECT sum(amount) AS total FROM {$ndbg}.30_payments_bills WHERE `paytype_id` = '$paytype_id' AND `date`='$date' 
		AND `ecid`='$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$sum4=$row['total'];
	debug($q,"paytTotal ");	
	
	$sumtotal=$sum1+$sum2+$sum3+$sum4;

}	/* has_ndbg */
else {
	$sumtotal=$sum1+$sum2;
}


if($has_pdbg){
	$q = "SELECT sum(amount) AS total FROM {$pdbg}.30_payments WHERE `paytype_id` = '$paytype_id' AND `date`='$date' 
		AND `ecid`='$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$sum5=$row['total'];
	debug($q,"paytTotal previous SY ");	

	$q = "SELECT sum(amount) AS total FROM {$pdbg}.30_payments_bills WHERE `paytype_id` = '$paytype_id' AND `date`='$date' 
		AND `ecid`='$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$sum6=$row['total'];
	$sumtotal=$sumtotal+$sum5+$sum6;
	debug($q,"paytTotal ");	

}	

return $sumtotal;

}	/* fxn */



function payDetails($db,$ecid,$date,$paytype_id,$has_ndbg){
$dbo=PDBO;
$dbg=PDBG;$ndbg=VCPREFIX.(DBYR+1).US.DBG;

$q = "SELECT p.*,c.name AS student,b.name AS bank FROM {$dbo}.30_payments AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid = c.id 
		LEFT JOIN "{$dbo}.`03_banks`" AS b ON p.bank_id = b.id 
		WHERE p.`paytype_id` = '$paytype_id' AND p.`date`='$date' AND `ecid`='$ecid'; ";
$sth = $db->querysoc($q);
$rows1 = $sth->fetchAll();

$q = "SELECT p.*,c.name AS student,b.name AS bank FROM {$dbo}.30_payments_bills AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid = c.id 
		LEFT JOIN "{$dbo}.`03_banks`" AS b ON p.bank_id = b.id 
		WHERE p.`paytype_id` = '$paytype_id' AND p.`date`='$date' AND `ecid`='$ecid'; ";		
$sth = $db->querysoc($q);
$rows2 = $sth->fetchAll();

if($has_ndbg){
	$q = "SELECT p.*,c.name AS student,b.name AS bank FROM {$ndbg}.30_payments AS p
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid = c.id 
			LEFT JOIN "{$dbo}.`03_banks`" AS b ON p.bank_id = b.id 
			WHERE p.`paytype_id` = '$paytype_id' AND p.`date`='$date' AND `ecid`='$ecid'; ";		
	$sth = $db->querysoc($q);
	$rows3 = $sth->fetchAll();

	$q = "SELECT p.*,c.name AS student,b.name AS bank FROM {$ndbg}.30_payments_bills AS p
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid = c.id 
			LEFT JOIN "{$dbo}.`03_banks`" AS b ON p.bank_id = b.id 
			WHERE p.`paytype_id` = '$paytype_id' AND p.`date`='$date' AND `ecid`='$ecid'; ";		
	$sth = $db->querysoc($q);
	$rows4 = $sth->fetchAll();
	$paydetails = array_merge($rows1,$rows2,$rows3,$rows4);	

} else {
	$paydetails = array_merge($rows1,$rows2);	

}
return $paydetails;

}	/* fxn */




