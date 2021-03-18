<?php
Class MistreeController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */


public function index($params=NULL){
	$dbo=PDBO;
	$db =& $this->baseModel->db;
	include_once(SITE.'views/elements/params_sq.php');
	$data['classrooms']	= fetchRows($db,"{$dbg}.05_classrooms","id,name,acid","level_id,name"); 	
  
	$data = isset($data)? $data : null;			
	// $this->view->render($data,'mis/indexMis');
}


public function indexMIS($params=NULL){
	$dbo=PDBO;
	$db =& $this->model->db;
	$_SESSION['q']="";
	$data['home']=$home=$_SESSION['home'];	
	include_once(SITE.'views/elements/params_sq.php');
	$data['qtr']=$_SESSION['qtr'];		
	$data['months']=$_SESSION['months'];	
	$data['levels']=$_SESSION['levels'];	
	$data['subjects']=$_SESSION['subjects'];	
	$data['departments']=$_SESSION['departments'];	
	$data['roles']=$_SESSION['roles'];	
	$data['teachers']=$_SESSION['teachers'];	
  
	$data = isset($data)? $data : null;			
	$this->view->render($data,'mis/indexMis');

}	/* fxn */


 
} 	/* MistreeController */

