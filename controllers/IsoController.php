<?php

Class IsoController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();		
	$acl = array(array(5,0));
	$this->permit($acl);				
	
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'iso/indexIso');
	
}	/* fxn */











}	/* IsoController */
