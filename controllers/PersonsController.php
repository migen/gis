<?php

Class PersonsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	echo "persons index";
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */




public function one($params=NULL){
require_once(SITE.'functions/personsFxn.php');
$pcid = isset($params[0])? $params[0]:$_SESSION['pcid'];
$db=&$this->baseModel->db;
$data['person'] = getPerson($db,$pcid);
$this->view->render($data,'persons/onePersons');

}	/* fxn */













}	/* BlankController */
