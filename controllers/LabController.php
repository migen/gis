<?php

Class LabController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	pr("Lab");
	// $this->view->render($data,'tests/index');

}	/* fxn */



public function livecss(){
	
	$data=NULL;
	$this->view->render($data,"lab/livecss","empty");
}


}	/* TestsController */
