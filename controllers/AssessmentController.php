<?php

Class AssessmentController extends Controller{	

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



/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function assess($params=NULL){
require_once(SITE."functions/feesFxn.php");
require_once(SITE."functions/assessmentFxn.php");
$db =& $this->model->db;

$data['scid']	= $scid		= isset($params[0])? $params[0]:$_SESSION['pcid'];
$data['ssy'] 	= $ssy	= $_SESSION['sy'];	
$data['sy']		= $sy 	= isset($params[1])? $params[1]:DBYR;
$data['year_start'] = $year_start = $_SESSION['settings']['year_start'];
$data['home']	= $home	= $_SESSION['home'];

$dbo=PDBO;
$dbg = VCPREFIX.$sy.US.DBG;
$negligible=isset($_GET['negligible'])? $_GET['negligible']:10;

if(DBYR==$sy){ checkBackAccount($db,$scid,$sy,$negligible); }
 
if(!empty($params)){ 
	$_SESSION['obid'] = isset($_SESSION['obid'])? $_SESSION['obid'] : feecode_id($db,'obal');
	$data['obid'] = $obid = $_SESSION['obid']; 
	$data['tsum'] 	= $tsum  = assessTsum($db,$dbg,$scid,$obid); 	
	
	$_SESSION['tfeeid'] = isset($_SESSION['tfeeid'])? $_SESSION['tfeeid'] : $this->feecode_id('tfee');
	$data['tfeeid'] = $tfeeid = $_SESSION['tfeeid']; 			
	$data['tpays'] 	= $tpays = tpays($db,$dbg,$scid); 
	
	$obalrows = feepayments($db,$dbg,$scid,$obid);
	$obalpaid=0;
	foreach($obalrows AS $row){
		$obalpaid+=$row['amount'];
	}	/* foreach */
	$data['obalpaid'] = $obalpaid;	
	$data['obal'] = $obal = $tsum['obal'];
	$leftbalance = $obal - $obalpaid;
	$data['leftbalance'] = $leftbalance;
	$data['is_blocked'] = $is_blocked = ($leftbalance>0)? true:false;
				
	$data['taux'] 	= $taux = taux($db,$dbg,$scid); 	
	$data['numtaux']  = count($taux);
	$data['cridnum'] = $cridnum = $tsum['cridnum'];

	$data['fees'] 	= $fees  = fees($db,$tsum['level_id'],$cridnum,$dbg);
	$data['numfees']  = count($fees);			
		
	/* advpays */
	$data4=advancePayments($db,$sy,$scid);	
	$data=array_merge($data,$data4);		
	
	
$sync=false;
$q = "";
	if(empty($tsum['tsumscid'])) { $q .= "INSERT INTO {$dbg}.03_tsummaries(`scid`,`crid`) 
		VALUES ('$scid','".$tsum['concrid']."');"; $sync=($sync)?$sync.=",Tsum":"Tsum"; }				

	if(empty($tsum['sumscid'])) { $q .= "INSERT INTO {$dbg}.05_summaries(`scid`,`crid`) 
		VALUES ('$scid','".$tsum['concrid']."');"; $sync=($sync)?$sync.=",Summ":"Summ"; }						

		
	if($sync){ 
		$url = "assessment/assess/$scid/$sy";	
		$this->model->db->query($q);
		echo "<h3>Synced, please refresh page.</h3>";		
	}

	
			
}	/* empty */


	$data['contacts'] = NULL;	
	$data['paymodes']=isset($_SESSION['paymodes'])? $_SESSION['paymodes']:fetchRows($db,"{$dbo}.`03_paymodes`","*","id");
	$data['feetypes']=isset($_SESSION['feetypes'])? $_SESSION['feetypes']:fetchRows($db,"{$dbo}.`03_feetypes`","*","name");	
 	$data['page_title'] = "Assessment";		
	
	/* 3 tpaid */
	$_SESSION['tfeeid'] = isset($_SESSION['tfeeid'])? $_SESSION['tfeeid'] : feecode_id($db,'tfee');
	$data['tfeeid'] = $tfeeid = $_SESSION['tfeeid']; 			
	$q=" SELECT SUM(p.amount) AS tpaid
	FROM {$dbo}.30_payments AS p WHERE p.scid='$scid' AND p.feetype_id='$tfeeid'; ";
	$sth=$db->querysoc($q);
	$s=$sth->fetch();
	$data['tpaid']=$s['tpaid'];
	if(isset($_GET['debug'])){ $data['q']=$_SESSION['q']; }
	
	$this->view->render($data,'assessment/assess');

}	/* fxn */





}	/* AssessmentController */
