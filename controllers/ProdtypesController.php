<?php

Class ProdtypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	

	include_once(SITE.'functions/prodtypesFxn.php');
	$db=$this->baseModel->db;$dbg=PDBO;
	$data=getAllProdtypes($db,$dbg);
	
	$this->view->render($data,"prodtypes/indexProdtypes");
	
}	/* fxn */







}	/* BlankController */
