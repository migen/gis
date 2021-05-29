<?php
Class PurgestudentsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}


public function beforeFilter(){
	parent::loginRedirect();
	$acl = array(array(5,0),array(9,0),array(5,1));
	$this->permit($acl,true);				
}	/* fxn */


public function index(){
	pr('purgestudents/one');

}	/* fxn */



public function one($params=NULL){		/* eradicate */
	$dbo=PDBO;
	require_once('functions/purge.php');	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1] : $_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	$url=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'purgestudents';
	
	pr('<h3>purgestudents/one/$scid/$sy</h3>');
	
	if($scid){ 
		$row=fetchRow($db,"{$dbo}.00_contacts",$scid,$fields="code,name");
		extract($row);
		purge($db,$sy,$scid); 
		flashRedirectUrl($url,"Purged - {$code} - {$name}");
	}	
	
}		/* fxn */


 
} 	/* PurgeController */
