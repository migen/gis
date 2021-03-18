<?php

Class AccordionController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="ABC";	
	$this->view->render($data=NULL,"accordion/indexAccordion");

}	/* fxn */


public function table(){
	
	$this->view->render($data=NULL,"accordion/tableAccordion");
	
}










}	/* BlankController */
