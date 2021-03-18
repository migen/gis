<?php

Class TsumController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$data="TSUM";$this->view->render($data,'abc/defaultAbc');
	
}	/* fxn */


public function scid($params=NULL){
$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		// pr();
		$tsum=$_POST['tsum'];
		$tbal=$_POST['tbal'];
		$db->update("{$dbg}.03_tsummaries",$tsum,"scid=$scid");
		$db->update("{$dbo}.tbalances",$tbal,"scid=$scid");
		flashRedirect("tsum/scid/$scid","Saved.");exit;
		
	}	/* post */
	
	
	if($scid){
		$q="SELECT ".DBYR." AS sy,c.name AS student,tsum.*,tbal.scid AS tbalscid,tbal.balance AS tbalance 
			FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid=c.id 
			INNER JOIN {$dbo}.tbalances AS tbal ON tbal.scid=c.id 
			WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['row']=$sth->fetch();
		
		$tbalscid=$data['row']['tbalscid'];
		if(empty($tbalscid)){
			$q="INSERT INTO {$dbo}.tbalances(scid)VALUES($scid); ";$db->query($q);
			flashRedirect("tsum/scid/$scid","Init Tbalance");exit;
		}
		
	}

	$this->view->render($data,"tsum/scidTsum");
	
	
	
}	/* fxn */


public function sync($params=NULL){
	require_once(SITE.'functions/syncFxn.php');
	$db=&$this->baseModel->db;$sy=$_SESSION['settings']['sy_enrollment'];
	syncTsum($db,$sy,$exe=true); 
	echo "Synced Tsum SY$sy";
}	





}	/* BlankController */
