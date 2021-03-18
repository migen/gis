<?php



function hasDuplicateOrno($db,$dbg,$orno,$addorno=false){
	$dbo=PDBO;
	if($addorno){
		return false;
	} else {
		$orno = trim($orno);
		$q = "SELECT id,orno FROM {$dbo}.30_payments WHERE `orno` = '$orno' LIMIT 1;";
		$sth = $db->querysoc($q);
		$row = $sth->fetch();
		return (empty($row))? false:true;
	}
}	/* fxn */

	
	
function getFeeDetails($db,$tuition_detail_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT t.*,td.*,l.name AS level,td.id AS tuition_detail_id
		   FROM {$dbg}.03_tdetails AS td
			INNER JOIN {$dbo}.`03_tuitions` AS t ON td.level_id = t.level_id
			INNER JOIN {$dbo}.`05_levels` AS l ON td.level_id = l.id
			WHERE td.`id`	= '$tuition_detail_id' LIMIT 1;	
		";
	debug($q,"fees: getFeeDetails ");	
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

/* for accounts tuition fees like lab,misc,tuition,comlab,etc... */
function particulars($dbg=PDBG,$db){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbo}.`03_feetypes` ";
	debug($q,"fees: particulars ");	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function tuition($db,$level_id,$num,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT t.*,l.name AS level 
		FROM {$dbo}.`03_tuitions` AS t 		
			INNER JOIN {$dbo}.`05_levels` AS l ON t.level_id = l.id		
		WHERE t.level_id	  = '$level_id'	AND t.num = '$num'; ";
	debug($q);
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */


function feetypes($db,$dbg=PDBG,$order='pfty.name'){
	$dbo=PDBO;
	$q = " SELECT fty.*,pfty.name AS parent,fty.id AS feetype_id
			FROM {$dbo}.`03_feetypes` AS fty 
				LEFT JOIN {$dbo}.`03_feetypes` AS pfty ON fty.parent_id = pfty.id
			ORDER BY $order;
		";
	debug($q,"fees: feetypes ");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function tsum($db,$dbg,$scid,$obid){	
	$dbo=PDBO;
	$q = "SELECT c.id AS ucid,c.parent_id AS pcid,c.is_active,c.is_cleared,c.code AS student_code,c.name AS student,c.role_id,
			tsum.*,t.*,cr.name AS classroom,l.name AS level,sxn.name AS section,tsum.scid AS tsumscid,c.crid AS concrid,
			pm.count AS numperiods,pm.code AS paymode_code,pm.name AS paymode,pm.dates AS paydates,
			taux.amount AS obal,taux.id AS tauxid,taux.scid AS tauxscid,summ.scid AS sumscid,
			cr.num AS cridnum,cr.acid AS acid ";
	$q .= "
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (t.level_id = cr.level_id && t.num = cr.num)
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`03_paymodes` AS pm on tsum.paymode_id = pm.id ";
	$q .= " LEFT JOIN {$dbg}.`30_auxes` AS taux ON 
				(taux.scid = c.id && taux.feetype_id = '$obid')	";		
	$q .= " WHERE c.id 	= '$scid'; ";
	debug($q,"fees: tsum ");	
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */





function feeaux($db,$dbg,$scid,$feeid){
	$dbo=PDBO;
	$q = "SELECT * FROM {$dbg}.`30_auxes` WHERE `scid` = '$scid' AND `feetype_id` = '$feeid' LIMIT 1; ";
	debug($q,"fees: feeaux ");	
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row;

}	/* fxn */



function levelTuition($db,$lvlid,$num=1,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT t.*,t.total AS assessed,t.resfee,l.name AS level 
		FROM {$dbo}.`03_tuitions` AS t 
		INNER JOIN {$dbo}.`05_levels` AS l ON t.level_id = l.id 
		WHERE t.level_id = '$lvlid' AND t.num = '$num' LIMIT 1; ";
	debug($q,"fees: levelTuition ");			
	$sth = $db->querysoc($q);
	$data['tuition'] = $tuition = $sth->fetch();
	$data['assessed'] = $tuition['total'];
	$data['level_id'] = $level_id = $tuition['level_id'];
	$data['lvlid'] = $level_id;
	$data['resfee'] = $resfee = $tuition['resfee'];	
	return $data;


}	/* fxn */


function syncLevelTsumSumm($db,$rows,$url,$dbg=PDBG){
	$dbo=PDBO;
	$sync=false;
	$q = "INSERT INTO {$dbg}.03_tsummaries(`scid`,`crid`)VALUES";
	foreach($rows AS $row){
		if(empty($row['tsumscid'])){			
			$q.= "('".$row['scid']."','".$row['concrid']."'),";			
		}
	}	
	$q = rtrim($q,",");
	$q.=";";	
	$r = $db->query($q);
	$sync1 = ($r)? 'Tsum':false;
	
/* 3c sync summ */
	$q = "INSERT INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`)VALUES";
	foreach($rows AS $row){
		if(empty($row['sumscid'])){			
			$q.= "('".$row['scid']."','".$row['concrid']."','".$row['acid']."'),";					
		}
	}	
	$q = rtrim($q,",");
	$q.=";";
	$r = $db->query($q);
	$sync2 = ($r)? 'Summ':false;
	$sync = $sync1.$sync2;
		
	if($sync){ 
		flashRedirect($url,"$sync synced.");
	}	/* sync */

}	/* fxn */



function levelBalances($db,$lvlid,$dbo=DBO,$dbg=PDBG,$sort="c.name",$order="ASC",$get=NULL){
	$dbo=PDBO;
	$cond="AND p.pointer>0";
	$cond .= (isset($get['paymode']) && ($get['paymode']>0))? " AND tsum.paymode_id=".$get['paymode']:NULL;
	$tmpout=isset($_GET['all'])? NULL:" AND cr.section_id<>2 ";
	$cond .= (isset($get['sxn']) && !empty($get['sxn']))? " AND cr.section_id=".$get['sxn']:$tmpout;
	// $cond .= " AND c.`sy`<>'".(DBYR+1)."' AND c.`is_enrolled`='1' "; 
	$next_sy=DBYR+1;	

	$q = "SELECT 
			c.is_active,c.code,c.name,c.name AS student,c.crid AS concrid,
			tsum.scid AS tsumscid,tsum.crid AS tsumcrid,tsum.*,
			summ.scid AS sumscid,
			c.id AS scid,pm.name AS paymode,
			t.total AS assessed,cr.name AS classroom,cr.acid AS acid,
			tsum.tdue AS tdue,tsum.tpaid,tsum.`balance` AS tbalance
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_paymodes` AS pm ON tsum.paymode_id = pm.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON (cr.level_id = t.level_id AND cr.num = t.num)
			LEFT JOIN {$dbo}.30_payments AS p ON p.scid=c.id				
		WHERE cr.level_id = '$lvlid' AND c.is_active=1 $cond GROUP BY p.scid ORDER BY $sort $order; ";	
	debug($q,"fees: levelBalances - rows of students ");			
	$data['q']=$q;
	$sth = $db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($rows);
	return $data;

}	/* fxn */



function soaData($db,$students,$tfeeid,$dbg=PDBG){
$dbo=PDBO;
$surgid=$_SESSION['surgid'];
$auxes = array();
$disces = array();
$tpays = array();
$apays = array();
foreach($students AS $row){

/* 1 auxes */
	$q = "SELECT a.*,ft.*,ft.name AS feetype,a.amount AS amountdue,a.due AS datedue 
			FROM {$dbg}.`30_auxes` AS a LEFT JOIN {$dbo}.`03_feetypes` AS ft ON a.feetype_id = ft.id			
		WHERE ft.is_discount<>1 AND  a.`scid` = '".$row['scid']."' ORDER BY a.feetype_id; ";
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$auxes[] = $a;	

/* 4 disces */
	$q = "SELECT a.*,ft.*,ft.name AS feetype,a.amount AS amountdue,a.due AS datedue 
			FROM {$dbg}.`30_auxes` AS a LEFT JOIN {$dbo}.`03_feetypes` AS ft ON a.feetype_id = ft.id			
		WHERE ft.is_discount=1 AND a.`scid` = '".$row['scid']."' ORDER BY a.due; ";
	$sth = $db->querysoc($q);
	$d = $sth->fetchAll();
	$disces[] = $d;	
	
/* 2 tpays */
	$q = "SELECT p.*,ft.*,ft.name AS feetype,p.amount AS amountpaid,p.date AS datepaid
			FROM {$dbo}.30_payments AS p LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id			
		WHERE p.`scid` = '".$row['scid']."' AND p.`feetype_id` = '$tfeeid' ORDER BY p.pointer,p.date; ";
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$tpays[] = $b;	

/* 3 apays */
	$q = "SELECT p.*,ft.*,ft.name AS feetype,p.amount AS amountpaid,p.date AS datepaid
			FROM {$dbo}.30_payments AS p LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id			
		WHERE p.`scid` = '".$row['scid']."' AND p.`feetype_id` <> '$tfeeid' AND p.`feetype_id`<>'$surgid'
		ORDER BY ft.id; ";
	$sth = $db->querysoc($q);
	$c = $sth->fetchAll();
	$apays[] = $c;	
	
}	/* foreach */

$data['auxes'] = $auxes;
$data['disces'] = $disces;
$data['tpays'] = $tpays;
$data['apays'] = $apays;

return $data;

}	/* fxn */


function dataTuits($db,$dbg=PDBG){
$dbo=PDBO;
if(!isset($_SESSION['paymodes'])){ $_SESSION['paymodes'] = fetchRows($db,"{$dbo}.`03_paymodes`","*","id"); } 
if(!isset($_SESSION['paytypes'])){ $_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","id"); } 
if(!isset($_SESSION['feetypes'])){ $_SESSION['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","*","name"); } 
if(!isset($_SESSION['banks'])){ $_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name"); } 

if(!isset($_SESSION['obid'])){ $_SESSION['obid'] = feecode_id($db,'obal'); } 
if(!isset($_SESSION['ovrid'])){ $_SESSION['ovrid'] = feecode_id($db,'ovr'); } 
if(!isset($_SESSION['tfeeid'])){ $_SESSION['tfeeid'] = feecode_id($db,'tfee'); } 
if(!isset($_SESSION['surgid'])){ $_SESSION['surgid'] = feecode_id($db,'surg'); } 

$data['paymodes'] = $_SESSION['paymodes'];	
$data['paytypes'] = $_SESSION['paytypes'];	
$data['feetypes'] = $_SESSION['feetypes'];	
$data['banks'] = $_SESSION['banks'];	

$data['obid'] = $_SESSION['obid']; 	
$data['tfeeid'] = $_SESSION['tfeeid']; 			
$data['surgid'] = $_SESSION['surgid']; 		

return $data;	
	

}	/* fxn */




function syncStudentTsumSumm($db,$scid,$tsum,$url,$dbg=PDBG){
$dbo=PDBO;
if(!empty($scid)){	/* has scid */
$sync=false;
$q = "";
	if(empty($tsum['tsumscid'])) { $q .= "INSERT INTO {$dbg}.03_tsummaries(`scid`,`crid`) 
		VALUES ('$scid','".$tsum['concrid']."');"; $sync=($sync)?$sync.=",Tsum":"Tsum"; }				
		
	if(empty($tsum['sumscid'])) { $q .= "INSERT INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`) 
		VALUES ('$scid','".$tsum['concrid']."','".$tsum['acid']."');"; 
		$sync=($sync)?$sync.=",Summ":"Summ"; }	
		
	if($sync){ 
		$db->query($q);
		flashRedirect($url,"$sync synced."); 
	}
}	/* has scid */

$data['paymode_id'] = $tsum['paymode_id'];
$data['tpaid'] = $tsum['tpaid'];
$data['addons'] = $tsum['addons'];
$data['discounts'] = $tsum['discounts'];
$data['surcharge'] = $tsum['surcharge'];
$data['tdue'] = $tsum['tdue'];
$data['assessed'] = $tsum['assessed'];
$data['balance'] = $tsum['balance'];
$data['remarks'] = $tsum['remarks'];

return $data;

}	/* fxn */



function payMonth($ldm){
	return date('F',strtotime($ldm));						
}	/* fxn */


function getPeriod($periods,$ldm=NULL){	
	$smoid = date('m',strtotime($ldm));	
	$month = date('F',strtotime($ldm));								
	$rperiods = explode(',',$periods);
	$count = count($rperiods);
	for($i=0;$i<$count;$i++){
		if($smoid==$rperiods[$i]){
			$num = ($i+1);
			$ordinalnum = getOrdinal($num);
			$orderpay = $ordinalnum." Payment - ".$month;
			return $orderpay;			
		}
	}	/* for */
	return false;
}	/* fxn */


function getTotalPaymodes($paymode_id){	/* for balances */
	switch($paymode_id){
		case 2: $count=2;break;
		case 3: $count=$_SESSION['settings']['paymode_num_months'];break;
		case 4: $count=4;break;
		default: $count=1;break;
	}	
	return $count;
}	/* fxn */



function getNumPaymodes($paydates,$cutoff){	/* for balances */
	$r1 = array_filter(explode(',',$paydates));	
	foreach($r1 AS $r){ $r2[] = trim($r); }
	$count=1;
	if(isset($r2)){
		foreach($r2 AS $r){ if($cutoff>=$r){ $count++; } }	
	}
	return $count;
}	/* fxn */


function switchPaymodes($paymode,$tuition){	/* for balances */
$dbo=PDBO;
$assessed=$tuition['y1_dpfee'];
switch($paymode){
	case 2:
		$data['dpfee'] = $tuition['s2_dpfee'];	
		$data['dpdue'] = $tuition['s2_dpdue'];	
		$data['annuity'] = ($assessed-$tuition['s2_dpfee']);break;
	case 3:
		$data['dpfee'] = $tuition['m3_dpfee'];		
		$data['dpdue'] = $tuition['m3_dpdue'];		
		$num=$_SESSION['settings']['paymode_num_months']-1;
		$data['annuity'] = ($assessed-$tuition['m3_dpfee'])/$num;break;
	case 4:
		$data['dpfee'] = $tuition['q4_dpfee'];		
		$data['dpdue'] = $tuition['q4_dpdue'];		
		$data['annuity'] = ($assessed-$tuition['q4_dpfee'])/3;break;		
	default:
		$data['dpfee'] = $tuition['y1_dpfee'];		
		$data['dpdue'] = $tuition['y1_dpdue'];		
		$data['annuity'] = $tuition['y1_dpfee'];break;		
}	/* switch */
return $data;

}	/* fxn */



function getDues($assessed,$dpfee,$annuity,$totalpaymodes,$numpaymodes,$discounts){
	$disc=($discounts/$totalpaymodes*$numpaymodes);
	$tfee=($numpaymodes>1)? ($annuity*($numpaymodes-1)):0;	
	$due=($dpfee+$tfee-$disc);	
	return $due;
}	/* fxn */


function getSurcharge($dueamt,$pmid,$duedate,$cutoff,$paymodes){
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




function updateLevelBalances($db,$lvlid,$dbg=PDBG){
require_once(SITE.'views/customs/'.VCFOLDER.'/customs.php');	
$dbo=PDBO;
$surgid=$_SESSION['surgid'];
$tfeeid=$_SESSION['tfeeid'];
$surgid=$_SESSION['surgid'];

/* 0 update tsum.apaid  */
$q = "UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
		SELECT c.id AS scid,c.code,c.name,b.apaid
		FROM {$dbo}.`00_contacts` AS c	
			INNER JOIN (
				SELECT p.scid,SUM(p.amount) AS apaid 
				FROM {$dbo}.30_payments AS p 
				INNER JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
				WHERE ft.is_discount = '0' AND ft.id <> '$tfeeid' AND ft.id <> '$surgid' 
				GROUP BY p.scid								
			) AS b ON b.scid = c.id		
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE cr.`level_id` = '$lvlid'
) AS y ON x.scid = y.scid
SET x.apaid=y.apaid;";
debug($q,"fees: updateLevelBalances - Apaid not surge ");			
$db->query($q);		/* 0 */

/* 1 update tsum.paid and tsum.tpaid */
$q = "UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
		SELECT c.id AS scid,c.code,c.name,b.paid
		FROM {$dbo}.`00_contacts` AS c	
			INNER JOIN (
				SELECT p.scid,SUM(p.amount) AS paid 
				FROM {$dbo}.30_payments AS p 
				WHERE p.feetype_id<>'$surgid'
				GROUP BY p.scid
			) AS b ON b.scid = c.id		
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id			
		WHERE cr.`level_id` = '$lvlid'
) AS y ON x.scid = y.scid
SET x.paid=y.paid,x.tpaid=y.paid; ";

debug($q,"fees: updateLevelBalances - Not Surge ");			
$db->query($q);		/* 1 */

/* 2 - discounts */
$q = "UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
		SELECT c.id AS scid,c.code,c.name,b.taux
		FROM {$dbo}.`00_contacts` AS c	
			INNER JOIN (
				SELECT p.scid,SUM(p.amount) AS taux 
				FROM {$dbg}.`30_auxes` AS p 
				INNER JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
				WHERE ft.is_discount = '1'
				GROUP BY p.scid				
			) AS b ON b.scid = c.id		
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id			
		WHERE cr.`level_id` = '$lvlid' 
) AS y ON x.scid = y.scid
SET x.discounts=y.taux; ";

debug($q,"fees: updateLevelBalances - discounts ");			
$db->query($q);	/* 2 */

/* 3 - addons */
$q = "
UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
		SELECT c.id AS scid,c.code,c.name,b.taux
		FROM {$dbo}.`00_contacts` AS c	
			INNER JOIN (
				SELECT p.scid,SUM(p.amount) AS taux 
				FROM {$dbg}.`30_auxes` AS p 
				INNER JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
				WHERE ft.is_discount = '0'
				GROUP BY p.scid				
			) AS b ON b.scid = c.id		
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id			
		WHERE cr.`level_id` = '$lvlid'
) AS y ON x.scid = y.scid
SET x.addons=y.taux; ";
debug($q,"fees: updateLevelBalances - non discounts ");			
$db->query($q);	/* 3 */


/* 5 assessed */
$q="UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
	SELECT 
		c.id AS scid,c.name,
		t.total AS assessed,(t.total+ifnull(tsum.addons,0)+ifnull(tsum.surcharge,0)-ifnull(tsum.discounts,0)-ifnull(tsum.tpaid,0)) 
		AS balance,(t.total+ifnull(tsum.addons,0)+ifnull(tsum.surcharge,0)-ifnull(tsum.discounts,0)) AS tdue		
	FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id	
		INNER JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid = c.id
		INNER JOIN {$dbo}.`03_tuitions` AS t ON (
			cr.level_id = t.level_id AND cr.num = t.num)
	WHERE cr.level_id =	'$lvlid' 
) AS y ON x.scid = y.scid
SET x.assessed=y.assessed,x.balance=y.balance,x.tdue=y.tdue; ";

debug($q,"fees: updateLevelBalances - assessed ");			
$db->query($q);		/* 4 */

		
}	/* fxn */



function updateStudentBalances($db,$scid,$dbg=PDBG){
$dbo=PDBO;
$surgid=$_SESSION['surgid'];

/* 1 update tsum.paid and tsum.tpaid */
$q = "UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
	SELECT p.scid,SUM(p.amount) AS paid FROM {$dbo}.30_payments AS p WHERE p.`scid` = '$scid' AND p.feetype_id<>'$surgid' 
	GROUP BY p.scid 
) AS y ON x.scid = y.scid
SET x.paid=y.paid,x.tpaid=y.paid;
";
$db->query($q);

/* 2 - discounts */
$q = "
UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
	SELECT p.scid,SUM(p.amount) AS taux 
	FROM {$dbg}.`30_auxes` AS p 
	INNER JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
	WHERE ft.is_discount = '1' AND p.scid = '$scid'
	GROUP BY p.scid				
) AS y ON x.scid = y.scid
SET x.discounts=y.taux;
";
$db->query($q);

/* 3 - addons */
$q = "
UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
	SELECT p.scid,SUM(p.amount) AS taux 
	FROM {$dbg}.`30_auxes` AS p 
	INNER JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
	WHERE ft.is_discount = '0' AND p.scid = '$scid'
	GROUP BY p.scid				
) AS y ON x.scid = y.scid
SET x.addons=y.taux; ";
$db->query($q);

/* 5 assessed */
$q="UPDATE {$dbg}.03_tsummaries AS x 
INNER JOIN (
	SELECT 
		c.id AS scid,c.name,
		t.total AS assessed,(t.total+ifnull(tsum.addons,0)+ifnull(tsum.surcharge,0)-ifnull(tsum.discounts,0)-ifnull(tsum.tpaid,0)) 
		AS balance,(t.total+ifnull(tsum.addons,0)+ifnull(tsum.surcharge,0)-ifnull(tsum.discounts,0)) AS tdue
	FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		INNER JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid = c.id
		INNER JOIN {$dbo}.`03_tuitions` AS t ON (
			cr.level_id = t.level_id AND cr.num = t.num)
	WHERE c.id = '$scid'
) AS y ON x.scid = y.scid
SET x.assessed=y.assessed,x.balance=y.balance,x.tdue=y.tdue;";
$db->query($q);


}	/* fxn */


function getNumByLvlSxn($db,$lvlid,$sxn,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT num FROM {$dbg}.05_classrooms WHERE `level_id`='$lvlid' AND `section_id`='$sxn' LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row['num'];

}	/* fxn */




