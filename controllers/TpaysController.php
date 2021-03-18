<?php

Class TpaysController extends Controller{	

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
	echo "tpays index";
	$this->view->render($data,'tests/index');

}	/* fxn */



public function edit($params){

require_once(SITE."functions/logs.php");
$db	=&	$this->model->db;

$tpid = $params[0];
$ssy = $_SESSION['sy'];
$sy = (isset($params[1]))? $params[1]:DBYR;
$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;

$q = "SELECT * FROM {$dbg}.`30_payments` WHERE `id` = '$tpid' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['row'] = $row = $sth->fetch();

if(isset($_POST['submit'])){
	// pr($_POST);
	$_POST = rally('trim',$_POST);
	$q = "
		UPDATE {$dbg}.`30_payments` SET	
			`date` = '".$_POST['date']."',
			`pointer` = '".$_POST['pointer']."',
			`bank_id` = '".$_POST['bank_id']."',
			`feetype_id` = '".$_POST['feetype_id']."',
			`paytype_id` = '".$_POST['paytype_id']."',
			`amount` = '".$_POST['amount']."',
			`orno` = '".$_POST['orno']."',
			`payer` = '".$_POST['payer']."',
			`reference` = '".$_POST['reference']."'
		WHERE `id` = '$tpid' LIMIT 1; ";
	// pr($q); exit;
	$this->model->db->query($q);
	
	/* 2 logs */
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['edit_payment'];
	$details = "Orig: ".$row['date'].' '.$row['details'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $row['scid'];
	$more['orno'] = $row['orno'];
	$more['feeid'] = $row['feetype_id'];
	$more['amount'] = $row['amount'];
	logThis($db,$ucid,$axn,$details,$more);	
	
	
	$url = "ledgers/pay/".$row['scid']."/$sy";
	flashRedirect($url,'Edited payments. Press Update to Refresh!');

}	/* post */

$data['feetypes'] = $_SESSION['feetypes'];
$data['paytypes'] = $_SESSION['paytypes'];
if(!isset($_SESSION['banks'])){ 
	$_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name"); 	 } 
$data['banks'] = $_SESSION['banks'];	


$this->view->render($data,'tpays/edit');

}	/* fxn */



/* use Ajax better */
public function delete($params){
	require_once(SITE."functions/logs.php");
	$db	=&	$this->model->db;

	$ssy	= $_SESSION['sy'];
	$tpid 	= $params[0];
	$sy 	= (isset($params[1]))? $params[1]:$ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$q = "SELECT * FROM {$dbg}.`30_payments` WHERE `id` = '$tpid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$scid = $row['scid'];
	
	/* 1 - tpays */
	$q = " DELETE FROM {$dbo}.30_payments WHERE `id` = '$tpid' LIMIT 1; ";		
	$this->model->db->query($q);
	
	/* 2 logs */
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['delete_payment'];
	$details = "Pymt Date: ".$row['date'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $row['scid'];
	$more['orno'] = $row['orno'];
	$more['feeid'] = $row['feetype_id'];
	$more['amount'] = $row['amount'];
	logThis($db,$ucid,$axn,$details,$more);	

	
	$url = "ledgers/pay/$scid/$sy";
	redirect($url);

}	/* fxn */







}	/* TpaysController */
