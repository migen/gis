<?php

/* old v3 lsm */
/* standalone for pay only */

function usedOrno($db,$orno,$reuseOrno=false,$sy=DBYR){
$dbo=PDBO;
if($reuseOrno){ return false; }
$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT id FROM {$dbg}.`30_payments` WHERE `orno`='$orno' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
if(!$row){
	$q="SELECT id FROM {$dbg}.`30_payments_bills` WHERE `orno`='$orno' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();	
}
return ($row)? true:false;
	
}	/* fxn */


function tsumStudent($db,$scid,$dbg=PDBG){
	$dbo=PDBO;	
	$q="SELECT tsum.*,c.code AS idno,c.code,c.name AS fullname,cr.name AS classroom,c.is_active,m.name AS paymode,
		m.count AS numperiods,m.dates AS paydates,cr.num AS cridnum,cr.level_id,cr.section_id,cr.acid AS acid,t.*
		FROM {$dbg}.03_tsummaries AS tsum 
			LEFT JOIN {$dbg}.05_summaries AS summ ON tsum.scid=summ.scid
			LEFT JOIN {$dbo}.`00_contacts` AS c ON tsum.scid=c.id
			LEFT JOIN {$dbo}.`03_paymodes` AS m ON tsum.paymode_id=m.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (t.level_id = cr.level_id && t.num = cr.num)
		WHERE tsum.scid=$scid LIMIT 1;";
	debug("ledgers-tsumStudent: ".$q);
	$sth=$db->querysoc($q);
	return $sth->fetch();

}	/* fxn */


function dataTuits($db,$dbg=PDBG){
$dbo=PDBO;
$data['paymodes'] = $_SESSION['paymodes'];	
$data['paytypes'] = $_SESSION['paytypes'];	
$data['feetypes'] = $_SESSION['feetypes'];	
$data['banks'] = $_SESSION['banks'];	

$data['obid'] = $_SESSION['obid']; 	
$data['ovrid'] = $_SESSION['ovrid']; 	
$data['tfeeid'] = $_SESSION['tfeeid']; 			
$data['surgid'] = $_SESSION['surgid']; 		

return $data;	
	

}	/* fxn */


function auxes($db,$dbg,$scid){	
	$dbo=PDBO;
	/* 1 */
	$q = "SELECT a.*,t.*,t.name AS feetype,a.amount AS dueamt,a.due AS duedate,a.id AS auxid 
			FROM {$dbg}.`30_auxes` AS a LEFT JOIN {$dbo}.`03_feetypes` AS t ON a.feetype_id = t.id			
		WHERE t.is_discount<>1 AND  a.`scid`=$scid ORDER BY a.feetype_id; ";
	$sth = $db->querysoc($q);
	$data['addons'] = $sth->fetchAll();
	debug("ledgers-auxes-not discounts: ".$q);

	/* 2 */
	$q = "SELECT a.*,t.*,t.name AS feetype,a.amount AS dueamt,a.due AS duedate,a.id AS auxid 
			FROM {$dbg}.`30_auxes` AS a LEFT JOIN {$dbo}.`03_feetypes` AS t ON a.feetype_id = t.id			
		WHERE t.is_discount=1 AND a.`scid`=$scid ORDER BY a.feetype_id; ";
	$sth = $db->querysoc($q);
	$data['discounts'] = $sth->fetchAll();
	debug("ledgers-auxes-discounts: ".$q);
	return $data;
	
	
}	/* fxn */



function pays($db,$dbg,$scid,$fields=NULL){	
	$dbo=PDBO;
	$surgid=$_SESSION['surgid'];
	$tfeeid=$_SESSION['tfeeid'];
 	
	/* tpays */
	$q = " SELECT p.*,p.id AS pid,f.name AS feetype FROM {$dbo}.30_payments AS p 
		LEFT JOIN {$dbo}.`03_feetypes` AS f ON p.feetype_id=f.id WHERE p.scid=$scid AND p.feetype_id=$tfeeid
		ORDER BY p.feetype_id,p.pointer; ";	
	debug("ledgers-pays-tfees: ".$q);
	$sth = $db->querysoc($q);
	$tpays = $sth->fetchAll();
	
	/* apays */
	$q = " SELECT p.*,p.id AS pid,f.name AS feetype FROM {$dbo}.30_payments AS p 
		LEFT JOIN {$dbo}.`03_feetypes` AS f ON p.feetype_id=f.id WHERE p.scid=$scid AND p.feetype_id!=$surgid 
		AND p.feetype_id!='$tfeeid' ORDER BY p.feetype_id,p.pointer; ";	
	debug("ledgers-pays-not tfees: ".$q);
	$sth = $db->querysoc($q);
	$apays = $sth->fetchAll();
	
	/* pays */
	$pays = array_merge($tpays,$apays);	
	$pr = array('tpays'=>$tpays,'apays'=>$apays,'pays'=>$pays);
	
	return $pr;
		

}	/* fxn */


function getDp($tsum,$pmid){
	switch($pmid){
		case 1: $dp['fee'] = $tsum['y1_dpfee']; $dp['due'] = $tsum['y1_dpdue']; break;
		case 2: $dp['fee'] = $tsum['s2_dpfee']; $dp['due'] = $tsum['s2_dpdue']; break;
		case 3: $dp['fee'] = $tsum['m3_dpfee']; $dp['due'] = $tsum['m3_dpdue']; break;
		default: $dp['fee'] = $tsum['q4_dpfee']; $dp['due'] = $tsum['q4_dpdue']; break;
	}	/* switch */
	return $dp;

}	/* fxn */


function dataPay($student,$auxes,$pays,$db,$dbg){
	$dbo=PDBO;
	$scid=$student['scid'];
	$dp=getDp($student,$student['paymode_id']);
	$data['dpfee']=$dpfee=$dp['fee'];	
	$data['dpdue']=$dpdue=$dp['due'];	
	$data['assessed'] = $assessed=$student['total'];
	$data['pmid'] = $pmid=$student['paymode_id'];
	$data['numperiods'] = $numperiods=$student['numperiods'];
	$data['today']=$_SESSION['today'];

	$tdisc=0;	
	foreach($auxes['discounts'] AS $row){ $tdisc+=$row['dueamt']; }
	$tadds=0;
	foreach($auxes['addons'] AS $row){ $tadds+=$row['dueamt']; }	

	$tpaid=0; 
	foreach($pays AS $row){ $tpaid+=round($row['amount'],2); }	

	$fpaid=0; 
	foreach($pays AS $row){ if($row['feetype_id']==1) $fpaid+=$row['amount']; }	

	$apaid=0; 
	foreach($pays AS $row){ if($row['feetype_id']!=1) $apaid+=$row['amount']; }		
	
	$data['tdisc']=$tdisc;
	$data['tadds']=$tadds;
	$data['tpaid']=$tpaid;
	$data['fpaid']=$data['ofpaid']=$fpaid;	/* o for original, fpaid is diminished */
	$data['apaid']=$data['oapaid']=$apaid;
	$data['numpays']=count($pays);

	$data['amtPerPeriod'] = $amtPerPeriod = ($numperiods>1)? ($assessed-$dpfee)/($numperiods-1):0;
	$data['discPerPeriod'] = $discPerPeriod=($tdisc)/$numperiods;
	$data['annuity'] = $annuity=$amtPerPeriod-$discPerPeriod;	
	$data['dpfeeGross'] = $dpfeeGross=$dpfee-$discPerPeriod;
	$data['paydates']=$paydates=$student['paydates'];
	$rpaydates=explode(',',$paydates);
	array_unshift($rpaydates,$dpdue);
	$data['rpaydates']=$rpaydates;
	$tdue=round($student['total'],2)+round($tadds,2)-round($tdisc,2)-round($tpaid,2);
	$q="UPDATE {$dbg}.03_tsummaries SET `addons`='$tadds',`discounts`='$tdisc',`paid`='$tpaid',
		`tpaid`='$tpaid',`tdue`='$tdue' WHERE `scid`=$scid LIMIT 1; ";	
	$db->query($q);
	$data['adjusted']=$assessed-$tdisc;	
	return $data;

}	/* fxn */


 
function getSurcharge($dueamt,$pmid,$duedate,$cutoff,$paymodes){
	$dbo=PDBO;
	$cutoff=trim($cutoff);
	$duedate=trim($duedate);
	$duedateTs = strtotime($cutoff);
	$cutoffTs = strtotime($duedate);
	$timeDiff = $duedateTs - $cutoffTs;
	$days = $timeDiff/86400;
	
	switch($pmid){
		case 4: $rounds=ceil($days/30);$rounds=($rounds<3)?$rounds:2;
			$surgrate=$paymodes[3]['surcharge'];$surg=$surgrate*$rounds*$dueamt/100;break;	
		case 3: $rounds=ceil($days/30);$rounds=($rounds<2)?$rounds:1;
			$surgrate=$paymodes[2]['surcharge'];$surg=$surgrate*$rounds*$dueamt/100;break;				
		case 2: $rounds=ceil($days/30);$rounds=($rounds<5)?$rounds:4;
			$surgrate=$paymodes[1]['surcharge'];$surg=$surgrate*$rounds*$dueamt/100;break;				
		default: $rounds=ceil($days/30);$rounds=($rounds<5)?$rounds:4;
			$surgrate=$paymodes[0]['surcharge'];$surg=$surgrate*$rounds*$dueamt/100;break;				
	}
	// echo "Pmid: $pmid - rounds: $rounds - surg: $surg, surgrate $surgrate <br />";
	// echo "P: $dueamt - D: $days - C: $cutoff - Due: $duedate Duets: $duedateTs - CTs: $cutoffTs <br />";
	return round($surg,2);
}	/* fxn */


function updateOrnoTsum($db,$dbg,$scid,$ecid,$orno,$pdamt){
	$dbo=PDBO;
	/* 2 */
	$q = "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid`=$ecid LIMIT 1;";
	$db->query($q);
	$_SESSION['orno'] = $orno; 				
	
	/* 3 update tsummaries paid and tpaid */
	$q = "UPDATE {$dbg}.03_tsummaries SET `paid`=`paid`+'$pdamt',`tpaid`=`tpaid`+'$pdamt' WHERE `scid`=$scid LIMIT 1;";
	$db->query($q);	

}	/* fxn */


function reusedOrnoTsum($db,$dbg,$scid,$ecid,$orno,$pdamt){
	$dbo=PDBO;
	/* 2 */	
	$q = "SELECT `orno` AS `bookorno` FROM {$dbo}.`03_orbooklets` WHERE `ecid`=$ecid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$_SESSION['orno'] = $row['bookorno']; 				
	
	/* 3 update tsummaries paid and tpaid */
	$q = "UPDATE {$dbg}.03_tsummaries SET `paid`=`paid`+'$pdamt',`tpaid`=`tpaid`+'$pdamt' WHERE `scid`=$scid LIMIT 1;";
	$db->query($q);	

}	/* fxn */



function ledgerPays($db,$table,$dbo,$dbg=PDBG,$where=NULL){
	$dbo=PDBO;
	$q=" SELECT p.*,p.id AS payid,sc.name AS student,
			ft.name AS feetype,pt.name AS paytype
		FROM {$dbg}.{$table} AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$dbo}.`03_paytypes` AS pt ON p.paytype_id = pt.id $where;";			
	debug("ledgers-ledgerPays: ".$q);
	return $q;	
	
}	/* fxn */


function insertTsum($db,$scid,$dbg=PDBG){
	$dbo=PDBO;
	$q="INSERT INTO {$dbg}.03_tsummaries(`scid`)VALUES('$scid'); ";
	$db->query($q);	
}	/* fxn */


