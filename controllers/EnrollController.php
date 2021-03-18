<?php

Class EnrolController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	// echo "Enrol Index";
	$data=NULL;
	$this->view->render($data,'enrol/index');

}	/* fxn */






























}	/* EnrolController */
