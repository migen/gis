<?php

class SyncaxisController extends Controller{	
/* Syncs and Counts for - admins,registrars,and mis,guidance controllers  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	$acl = array(array(5,0));
	$this->permit($acl);				
	
}	/* fxn */

public function index(){
	
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'syncaxis/indexSyncaxis');
}	/* fxn */


public function showTfeedetails($params=NULL){
	$sy=isset($params[0])? $params[0]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$q="UPDATE {$dbo}.03_tfeedetails AS d 
		INNER JOIN {$dbo}.03_feetypes AS t ON d.feetype_id=t.id
		SET d.is_displayed=1 
		WHERE d.sy=$sy AND t.parent_id < 1;";
	pr("&exe");pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
	}
		
}	/* fxn */



}	/* SyncsController */