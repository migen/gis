<?php

Class AbcController extends Controller{	

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
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crid($params=NULL){
	if(!isset($params[0])){ pr("Classrooms ID NOT set."); exit; }
	$data['crid']=$crid=$params[0];
	
	
	
}	/* fxn */










}	/* BlankController */
