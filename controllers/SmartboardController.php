<?php

Class SmartboardController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="unisubjects/add";	
	$this->view->render($data,'smartboard/indexSmartboard');
	
}	/* fxn */













}	/* BlankController */
