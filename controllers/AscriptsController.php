<?php

Class AscriptsController extends Controller{	

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
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */




}	/* BlankController */
