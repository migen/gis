<?php

Class ApsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index($params=NULL){
	
	$data="APS";	
	pr($params);
	// $this->view->render($data,'abc/defaultAbc');
}	/* fxn */

public function login(){
	// pr("aps hi");
	$this->view->render(NULL,"users/login");
}












}	/* BlankController */
