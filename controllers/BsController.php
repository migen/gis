<?php

Class BsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Bootstrap";	

	$this->view->render($data,'bs/indexBs','bootstrap');
}	/* fxn */


public function modal(){
	
	$data="Bootstrap";	


	
	$this->view->render($data,'bs/modalBs','bootstrap');
}	/* fxn */












}	/* BlankController */
