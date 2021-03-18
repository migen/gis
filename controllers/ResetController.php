<?php

Class ResetController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;
	$db=&$this->baseModel->db;
	clearstatcache();	
	

}	/* fxn */




}	/* BlankController */
