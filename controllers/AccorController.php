<?php

Class AccorController extends Controller{	

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
	$dbg=&$dbg;
	$data=NULL;	
	$this->view->render($data,'accor/indexAccor');
		
}	/* fxn */



}	/* BlankController */
