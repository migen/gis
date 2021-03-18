<?php

Class AwardsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$data=isset($data)? $data:NULL;
	$data['levels']=$_SESSION['levels'];
	$data['clssrooms']=$_SESSION['classrooms'];
	
	$this->view->render($data,'awards/indexAwards');	

}	/* fxn */



public function border(){
	$data=NULL;
	$this->view->render($data,'awards/border');
}	/* fxn */



}	/* BlankController */
