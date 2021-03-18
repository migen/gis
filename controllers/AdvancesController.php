<?php

Class AdvancesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function student($params=NULL){
require_once(SITE."functions/advances.php");
$db =& $this->model->db;

$data['scid'] = $scid = isset($params[0])? $params[0]:false;
$data['ssy'] = $ssy	= $_SESSION['sy'];	
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$data['home'] = $home = $_SESSION['home'];

$dbo = PDBO;$dbg = PDBG;
$ndbm=VCPREFIX.(DBYR+1).US.DBG;$ndbg=VCPREFIX.(DBYR+1).US.DBG;
if($scid) {

$q="SELECT c.name AS student,c.id AS scid,c.code AS studcode,cr.name AS classroom 
FROM {$dbo}.`00_contacts` AS c 
LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
WHERE c.id='$scid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['student']=$sth->fetch();

$q="SELECT p.*,c.name AS student,c.code AS studcode,ft.name AS feetype
FROM {$ndbg}.30_payments AS p 
LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid=c.id
LEFT JOIN {$ndbm}.03_feetypes AS ft ON p.feetype_id=ft.id
WHERE p.scid='$scid'
;	
";
// pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);



if(isset($_POST['submit'])){
	$post=$_POST;
	advancePay($db,$scid,$post,$sy);	

	/* 2 */
	$orno=trim($post['orno']);	
	$ecid=$_SESSION['ucid'];
	$q = "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '$ecid' LIMIT 1;";
	$db->query($q);
	$_SESSION['orno'] = $orno; 				
		
	$url="advances/student/$scid/$sy";
	redirect($url);	
	exit;
	
}	/* post */

} /* scid */


$data['last_orno'] = $last_orno = $_SESSION['orno'];
$data['paytypes']=$_SESSION['paytypes'];
$this->view->render($data,'advances/student');



}	/* fxn */


public function report(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;

if(isset($_GET['filter'])){
	require_once(SITE."functions/advances.php");
	require_once(SITE."functions/payments.php");
	$params = $_GET;
	
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
	// pr($params);
	// exit;
		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }				

	if (!empty($params['lvlid'])){ $cond .= " AND cr.level_id = '".$params['lvlid']."'"; }					
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }						
	if (!empty($params['scid'])){ $cond .= " AND p.scid = '".$params['scid']."'"; }					
	if (!empty($params['ecid'])){ $cond .= " AND p.ecid = '".$params['ecid']."'"; }				
	
	if (!empty($params['feetype_id'])){ $cond .= " AND p.feetype_id = '".$params['feetype_id']."'"; }				
	if (!empty($params['paytype_id'])){ $cond .= " AND p.paytype_id = '".$params['paytype_id']."'"; }				
	
	$where=" WHERE 1=1 $cond GROUP BY p.orno ORDER BY $sort $order $condlimits";	
	$table="next_payments";
	$q = getPayments($db,$table,$dbo,$dbg,$where);				
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();	/* enrol */
		
	$count=count($rows);
	$ornos=array();
	for($i=0;$i<$count;$i++){
		if($rows[$i]['numrows']>1){
			$ornos[$i]=getOrnoBreakdowns($db,"{$dbg}.`next_payments`",$rows[$i]['orno']);
		}
	}
	
		
	$data['rows']=$rows;	
	$data['ornos']=$ornos;
	$data['count'] = count($rows);

} 	/* filter */


if(!isset($_SESSION['feetypes'])){ 
	$_SESSION['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","*","name"); 	 } 
$data['feetypes'] = $_SESSION['feetypes'];	
if(!isset($_SESSION['paytypes'])){ 
	$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","name"); 	 } 
$data['paytypes'] = $_SESSION['paytypes'];	
if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","*","id"); 	 } 
$data['levels'] = $_SESSION['levels'];	
if(!isset($_SESSION['classrooms'])){ 
	$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];	

$this->view->render($data,'advances/report');





}	/* fxn */


public function edit($params){
$data['pid']=$pid=$params[0];
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$sy=DBYR;
$nsy=$sy+1;
$ndbg=VCPREFIX.$nsy.US.DBG;

$q="
SELECT p.*,c.name AS student
FROM {$ndbg}.30_payments AS p
LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid=c.id
WHERE p.id='$pid' LIMIT 1;
";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$data['scid']=$scid=$data['row']['scid'];

if(isset($_POST['submit'])){
	// pr($_POST);
	$date=$_POST['date'];
	$orno=$_POST['orno'];	
	$ecid=$_POST['ecid'];	
	$paytype_id=$_POST['paytype_id'];	
	$bank_id=$_POST['bank_id'];	
	$reference=$_POST['reference'];	
	$pointer=$_POST['pointer'];	
	$amount = str_replace(",","",$_POST['amount']);		
	$q="UPDATE {$ndbg}.30_payments SET `date`='$date',`orno`='$orno',`ecid`='$ecid',
		`amount`='$amount',`paytype_id`='$paytype_id',`bank_id`='$bank_id',
		`reference`='$reference',`pointer`='$pointer' WHERE `id`='$pid' LIMIT 1;";
				
	$db->query($q);
	$url="ledgers/pay/$scid/$sy";
	redirect($url);
	exit;

}	/* post */

$data['paytypes']=$_SESSION['paytypes'];
$data['banks']=$_SESSION['banks'];
$this->view->render($data,'advances/edit');


}	/* fxn */


public function delete($params){
$pid=$params[0];
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$q="
SELECT p.*
FROM {$dbg}.next_payments AS p
WHERE p.id='$pid' LIMIT 1;
";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$data['scid']=$scid=$data['row']['scid'];

$q="DELETE FROM {$dbg}.next_payments WHERE `id`='$pid' LIMIT 1; ";
$db->query($q);
$url="ledgers/pay/$scid";
redirect($url);

$this->view->render($data,'advances/edit');


}	/* fxn */



public function pay($params=NULL){
require_once(SITE."functions/advances.php");
$db =& $this->model->db;
$data['scid']=$scid=(isset($params[0]))? $params[0]:false;
$ssy=$_SESSION['sy'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$dbo=PDBO;$dbg=PDBG;

$data['cutoff']=isset($_GET['cutoff'])? $_GET['cutoff']:$_SESSION['today'];
$url="advances/pay/$scid";

if($scid){
	$data['ecid']=$ecid=$_SESSION['ucid'];
	$data['student'] = $student = tsumStudent($db,$scid,$dbg);	
	
	$pr = pays($db,$dbg,$scid); 	
	$data['pays'] = $pays = $pr['pays'];
	$data['tpays'] = $tpays = $pr['tpays'];
	$data['apays'] = $apays = $pr['apays'];
	
	// pr($pays);	
	// pr($tpays);	
	// pr($apays);	
	// exit;

	$data1 = dataTuits($db,$dbg);	
	$data2 = auxes($db,$dbg,$scid); 	
	$data3 = dataPay($student,$data2,$pays,$db);		
	$data=array_merge($data,$data1,$data2,$data3);		
	$data['last_orno'] = $last_orno = $_SESSION['orno'];
	
	/* advpays */
	$table="next_payments";
	$where=" WHERE p.scid='$scid' ";	
	$q = ledgerPays($db,$table,$dbo,$dbg,$where,'Advance',3);			
	$sth = $db->querysoc($q);
	$data['advpays'] = $sth->fetchAll();	/* enrol */
	$data['num_advpays']=count($data['advpays']);	
			
}	/* scid */

if(isset($_POST['submit'])){
	$pay=$_POST['pay'];	
	$pdamt = str_replace(",","",$pay['amount']);			
	$orno = trim($pay['orno']);	
	
if($pdamt>0){
	/* 1 check orno duplicates */
	$reuseOrno = isset($_POST['recycle'])? true:false;	
	$usedOrno = usedOrno($db,$orno,$reuseOrno);			
	if($usedOrno){ flashRedirect($url,"OR already used."); }	
	
	/* 2 */
	$multi=$_POST['multi'];
	$paytype_id=$pay['paytype_id'];	
	$bank_id=$pay['bank_id'];	
	$reference=trim($pay['reference']);
	$date=$pay['date'];
	$q="INSERT IGNORE INTO {$dbo}.30_payments(`scid`,`ecid`,`date`,`orno`,`feetype_id`,`pointer`,`amount`,";
	$q.="`paytype_id`,`bank_id`,`reference`) VALUES ";	
	foreach($multi AS $post){
		if(isset($post['checked'])){
			$fid=$post['feetype_id'];
			$ptr=$post['pointer'];
			$amt = str_replace(",","",$post['checked']);		
			$q.="('$scid','$ecid','$date','$orno','$fid','$ptr','$amt','$paytype_id','$bank_id','$reference'),";
		}
	}	/* foreach */
	$q=rtrim($q,',');$q.=";";
	
	/* 2 bills payment non enrolment related */
	$bills=$_POST['bills'];
	if(($bills['feetype_id']>0) && ($bills['amount']>0)){
		$bfid=$bills['feetype_id'];
		$bamt=$bills['amount'];
		$q.="INSERT IGNORE INTO {$dbo}.30_payments_bills(`scid`,`ecid`,`date`,`orno`,`feetype_id`,`amount`,
			`paytype_id`,`bank_id`,`reference`) VALUES ('$scid','$ecid','$date','$orno','$bfid','$bamt',
			'$paytype_id','$bank_id','$reference'); ";
	}
	
	// pr($q); exit;
	$sth=$db->query($q);
	$msg=($sth)? 'Added payment.':'Failed.';
	
	/* 3 - update orno, 3 - update tsumm */
	updateOrnoTsum($db,$dbg,$scid,$ecid,$orno,$pdamt);	
	flashRedirect($url,$msg);
	exit;
}	/* $pdamt */


}	/* post */

$data=isset($data)? $data:null;

// pr($student);
$nxtlvl=$student['level_id']+1;
$data['advtuit']=$advtuit = advtuit($db,$nxtlvl);
pr($advtuit);

$this->view->render($data,'advances/pay');

}	/* fxn */

















}	/* AdvancesController */
