<?php

Class LedgersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();			
	$acl = array(array(RMIS,0),array(RAXIS,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl,0);				
	
}


public function index(){ redirect('ledgers/pay'); }		/* fxn */


/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function edit($params=NULL){
$dbo=PDBO;	
require_once(SITE."functions/logs.php");
require_once(SITE."functions/orno.php");
require_once(SITE."functions/fees.php");
require_once(SITE."functions/feesFxn.php");
require_once(SITE."functions/assessmentFxn.php");

$data['ecid'] = $ecid = $_SESSION['ucid'];
$data['scid']	= $scid	= isset($params[0])? $params[0]:false;
$data['ssy'] 	= $ssy	= $_SESSION['sy'];	
$data['sy']		= $sy 	= isset($params[1])? $params[1]:DBYR;

$data['home']	= $home	= $_SESSION['home'];
$data['today']	= $_SESSION['today'];
$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

$num = 1;

/* 2 post */
if(isset($_POST['submit'])){
	$addorno = isset($_POST['addorno'])? true:false;	
	$hasDuplicateOrno = hasDuplicateOrno($db,$dbg,$_POST['orno'],$addorno);	
	
if($hasDuplicateOrno){
	$url = "ledgers/edit/$scid";
	flashRedirect($url,"OR Number has been used.");
}	/* duplicate orno */
	
	
	$_POST['discounts'] = str_replace(",","",$_POST['discounts']);
	$totalpaid = str_replace(",","",$_POST['totalpaid']);	

 	/* 1 - tsum */		
	$q = "";	
	$remarks = trim($_POST['remarks']);
	$pmid = trim($_POST['paymode_id']);
	if($_POST['amount']!=0){	/* pay */
		$_POST = rally('trim',$_POST);
		$_POST['amount'] = str_replace(",","",$_POST['amount']);		
		$orno = preg_replace("([^0-9-/])","",$_POST['orno']);												
				
		$q .= "INSERT INTO {$dbg}.`30_payments`(`scid`,`ecid`,`date`,`bank_id`,`feetype_id`,`paytype_id`,`amount`,`orno`,`pointer`,
			`payer`,`details`) VALUES ('$scid','$ecid','".$_POST['date']."','".$_POST['bank_id']."','".$_POST['feetype_id']."','".$_POST['paytype_id']."','".$_POST['amount']."','$orno','".$_POST['pointer']."','".$_POST['payer']."','".$_POST['details']."');";
		$q .= "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '$ecid' LIMIT 1;";					
		$_SESSION['orno'] = $orno; 				
				
		$ucid = $_SESSION['ucid'];
		$axn = $_SESSION['axn']['payment'];
		$details = $_POST['details'];
		$more['qtr'] = $_SESSION['qtr'];
		$more['scid'] = $scid;
		$more['orno'] = $orno;
		$more['feeid'] = $_POST['feetype_id'];
		$more['amount'] = $_POST['amount'];
		logThis($db,$ucid,$axn,$details,$more);	
				
	}	/* pay */		
	
	$q .= " UPDATE {$dbg}.`03_tsummaries` 
		SET `remarks` = '$remarks',`paymode_id` = '$pmid' WHERE `scid` = '".$scid."' LIMIT 1; ";
	
	// pr($q); exit;
	$db->query($q);
	$url = "ledgers/edit/$scid/$sy";
	$this->flashRedirect($url,"Fees record updated.");

}	/* post */


if(isset($_POST['multipay'])){
	require_once(SITE."functions/payments.php");
	$posts=array();
	foreach($_POST['multi'] AS $row){
		if(isset($row['checked'])){ $posts[] = $row; }	
	}	/* foreach */
	$details = $_POST['mpay'];
	multipay($db,$details,$posts);
	$url="ledgers/edit/$scid";
	flashRedirect($url,'Multiple payments made.');
	exit;
}	/* multi */

/* 1 */
$dataTuits = dataTuits($db,$dbg);
$data = array_merge($data,$dataTuits);	

if($scid){ 

	updateStudentBalances($db,$scid);
		
	$data['tsum'] 	= $tsum  = tsum($db,$dbg,$scid,$data['obid']); 
	$data['surchargerow'] 	= $surchargerow  = feeaux($db,$dbg,$scid,$data['surgid']); 
	$data['surcharge'] 		= $surchargerow['amount'];
	$data['surgpayments'] 	= $surgpayments  = feepayments($db,$dbg,$scid,$data['surgid']); 
	
	$data['has_oldbalance'] = $has_oldbalance = ($tsum['obal']>0)? true:false;
	$data['current'] = ($sy==DBYR)? true:false;
	
	$data['tpays'] 	= $tpays = tpays($db,$dbg,$scid); 
	$data['count']  = count($tpays);
	
	$data['taux'] 	= $taux = taux($db,$dbg,$scid); 
	$data['numtaux']  = count($taux);

	$data['fees'] 	= $fees  = fees($db,$tsum['level_id'],$num,$dbg);
	$data['numfees']  = count($fees);			

	$url = "ledgers/edit/$scid";		
	$dataTsum = syncStudentTsumSumm($db,$scid,$tsum,$url,$dbg);
	$data = array_merge($data,$dataTsum);
	
	$all = (isset($_GET['all']))? true:false;
	
}	/* scid */


	$data['contacts'] = NULL;
	$data['last_orno'] = lastOrno($db,$_SESSION['ucid'],$dbg);
	
	$this->view->render($data,'ledgers/edit');


}	/* fxn */



public function pay($params=NULL){
$this->view->js = array('js/jquery.js','js/vegas.js','js/vegas_axis.js');	
require_once(SITE."functions/ledgers.php");
require_once(SITE."functions/feesFxn.php");
require_once(SITE."views/customs/".VCFOLDER."/customs.php");

$data['scid']=$scid=(isset($params[0]))? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db =& $this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$url="ledgers/pay/$scid/$sy";
$data['cutoff']=isset($_GET['cutoff'])? $_GET['cutoff']:$_SESSION['today'];
$url="ledgers/pay/$scid/$sy";

if($scid){
	$data['ecid']=$ecid=$_SESSION['ucid'];
		
	$data['student'] = $student = tsumStudent($db,$scid,$dbg);
	if(!$student){ insertTsum($db,$scid,$dbg); flashRedirect($url,"Tsum #{$scid} synced."); } 
	
	$pr = pays($db,$dbg,$scid); 
	
	$data['pays'] = $pays = $pr['pays'];
	$data['tpays'] = $tpays = $pr['tpays'];
	$data['apays'] = $apays = $pr['apays'];

	$data1 = dataTuits($db,$dbg);		
	$data2 = auxes($db,$dbg,$scid); 		
	$data3 = dataPay($student,$data2,$pays,$db,$dbg);		
	
	/* advpays */
	$data4=advancePayments($db,$sy,$scid);	
	
	$data=array_merge($data,$data1,$data2,$data3,$data4);		
	$data['last_orno'] = $last_orno = $_SESSION['orno'];
		

if($student['total']!=$student['assessed']){ require_once(SITE."functions/sync_tuitions.php"); syncAllAssessed($db,$sy); }
	
}	/* scid */




if(isset($_POST['submit'])){
	// pr($_POST); exit;
	
	$pay=$_POST['pay'];	
	$pdamt = str_replace(",","",$pay['amount']);			
	$orno = trim($pay['orno']);	
	
if($pdamt>0){
	/* 1 check orno duplicates */
	$reuseOrno = isset($_POST['recycle'])? true:false;	
	$usedOrno = usedOrno($db,$orno,$reuseOrno,$sy);			
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
	$sth=$db->query($q);
	$msg=($sth)? 'Added payment.':'Failed.';
	
	/* 3 - update orno, 3 - update tsumm */
	if($reuseOrno){
		reusedOrnoTsum($db,$dbg,$scid,$ecid,$orno,$pdamt);	
	} else { updateOrnoTsum($db,$dbg,$scid,$ecid,$orno,$pdamt); }
	flashRedirect($url,$msg);
	exit;
}	/* $pdamt */



}	/* post */



$data=isset($data)? $data:null;


$this->view->render($data,'ledgers/payLedgers');

}	/* fxn */


public function refund($params=NULL){
$data['scid']=$scid=$params[0];
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	// pr($_POST);exit;
	$amount = str_replace(",","",$_POST['amount']);
	$amount*=-1;
	$ecid=$_POST['ecid'];$feetype_id=$_POST['feetype_id'];$pointer=$_POST['pointer'];
	$orno=$_POST['orno'];$reference=$_POST['reference'];$date=$_POST['date'];
	
	$q="INSERT INTO {$dbo}.30_payments(`ecid`,`scid`,`amount`,`orno`,`reference`,`date`,`feetype_id`,`pointer`) VALUES 
		('$ecid','$scid','$amount','$orno','$reference','$date','$feetype_id','$pointer');";
	$sth=$db->query($q);
	$url="ledgers/pay/$scid";
	$msg=($sth)? "Success":"Failure";
	flashRedirect($url,$msg);
	
}	/* post */


$q="SELECT c.id AS scid,c.name AS student FROM {$dbo}.`00_contacts` AS c WHERE c.id='$scid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

$this->view->render($data,"ledgers/refundLedgers");


}	/* fxn */






}	/* LedgersController */
