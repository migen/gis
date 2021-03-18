<?php

function getOrnoBreakdowns($db,$table,$orno){
	$dbo=PDBO;
	$q="SELECT * FROM $table WHERE `orno`='$orno';";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function paymentsRows($db,$row,$where=NULL){
	$dbo=PDBO;$vsy=$row['vsy'];$pdbg=$row['pdbg'];
	$dbg=PDBG;
	// $pdba=$row['pdba'];
	$ptable=$row['ptable'];
	$ortype=$row['ortype'];$ortype_id=$row['ortype_id'];		

	$q=" SELECT $vsy AS vsy,p.*,p.id AS payid,sc.name AS student,ec.name AS employee,
			ft.name AS feetype,pt.name AS paytype,cr.name AS classroom,
			'$ptable' AS ptable,'$ortype' AS ortype,'$ortype_id' AS ortype_id		
		FROM {$pdbg}.{$ptable} AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON p.scid = summ.scid
			LEFT JOIN {$dbo}.`00_contacts` AS ec ON p.ecid = ec.id
			LEFT JOIN {$pdbg}.03_feetypes AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$pdbg}.03_paytypes AS pt ON p.paytype_id = pt.id
			LEFT JOIN {$pdbg}.05_classrooms AS cr ON summ.crid = cr.id $where;";			
	// echo "payments payRows: ";pr($q);
	return $q;	
	
}	/* fxn */


function getPayments($db,$table,$dbo,$dbg=PDBG,$where=NULL){
	$dbo=PDBO;$dbg=PDBG;
	$q=" SELECT p.*,p.id AS payid,sc.name AS student,ec.name AS employee,
			ft.name AS feetype,pt.name AS paytype,cr.name AS classroom,
			'Enroll' AS ortype,'1' AS ortype_id,
			SUM(p.amount) AS amount,SUM(p.amount) AS subtotal,count(p.id) AS numrows
		FROM {$dbg}.{$table} AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON p.scid = summ.scid
			LEFT JOIN {$dbo}.`00_contacts` AS ec ON p.ecid = ec.id
			LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$dbo}.`03_paytypes` AS pt ON p.paytype_id = pt.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id $where;";			
	// echo "payments getPayments: ";pr($q);
	return $q;	
	
}	/* fxn */



function multipay($db,$details,$posts){
$ecid=$details['ecid'];
$scid=$details['scid'];
$orno=$details['orno'];
$date=$details['date'];
$paytype_id=$details['paytype_id'];
$bank_id=$details['bank_id'];
$payer=$details['payer'];

$dbo=PDBO;$dbg=PDBG;
$q="INSERT INTO 
	{$dbo}.30_payments(`ecid`,`scid`,`orno`,`date`,`paytype_id`,`bank_id`,`payer`,`pointer`,`feetype_id`,`amount`) VALUES ";
foreach($posts AS $post){
	$q.="('$ecid','$scid','$orno','$date','$paytype_id','$bank_id','$payer','".$post['pointer']."','".$post['feeid']."',
	'".$post['checked']."'),";
}
$q=rtrim($q,",");
$q.=";";
// pr($q);
$db->query($q);

$q = "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '$ecid' LIMIT 1;";
$db->query($q);
$_SESSION['orno'] = $orno; 				

}	/* fxn */
