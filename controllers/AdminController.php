<?php

Class AdminController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data=NULL;
	$this->view->render($data,'admin/indexAdmin');
}	/* fxn */


public function reset($params){
	$dbo=PDBO;
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_admin.php");
	$db=&$this->model->db;		
	sessionizeAdmin($db);	
	redirect($_SESSION['home']);
	
} 	/* fxn */





























}	/* AdminController */
