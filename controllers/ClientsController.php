<?php

Class ClientsController extends Controller{	

public function __construct(){
	parent::__construct();		
	sudo();
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	// $this->beforeFilter();

	
}

public function beforeFilter(){
	// parent::beforeFilter();
	

}

public function index(){	
	$this->view->render($data="Clients",'clients/indexClient');
}	/* fxn */









}	/* BlankController */
