<?php

Class CCposController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	
	$data="CCpos";$this->view->render($data,'abc/defaultAbc');
	
}	/* fxn */




}	/* BlankController */
