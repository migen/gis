<?php
/** 
 * @copyright MIDASGEN | PCMED-MIGEN
  
 */

Class AccountsController extends Controller{

public function __construct(){
	parent::__construct();
	$this->beforeFilter();	
	parent::loginRedirect();	
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}


public function beforeFilter(){

	$acl = array(array(RMIS,0),array(RAXIS,0));	
	/* 2nd param is strict,default is false */	
	$this->permit($acl,0);				


}




public function index($params=NULL){
	$dbo=PDBO;
	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[0])? $params[0] : $ssy;
	$dbg=VCPREFIX.$sy.US.DBG;

	$data['is_treasurer'] = ($_SESSION['user']['role_id']==RAXIS && $_SESSION['user']['privilege_id']==0)? true:false;
	$data['is_mis'] = ($_SESSION['user']['role_id']==RMIS)? true:false;
	$this->view->render($data,'accounts/index');

}	/* fxn */




public function reset($params=NULL){
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_account.php");
	$db	=&	$this->model->db;		
	sessionizeAccount($db);	
	redirect($_SESSION['home']);
} 	/* fxn */



public function levels($params=NULL){
	$dbo=PDBO;
	$dbg=PDBG;	
	$data['levels'] = $_SESSION['levels'];
	$data['num_levels']	 = count($data['levels']);
	$this->view->render($data,'accounts/levels');

}	/* fxn */

















} 	/* AccountsController */


