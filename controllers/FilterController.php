<?php

Class FilterController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	redirect("filters");
	$data="check Filters";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */











}	/* BlankController */
