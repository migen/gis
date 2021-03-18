<?php

Class XyzController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	pr('xyz');
}	/* fxn */



public function hello($params=NULL){
	pr($params);	
}


public function test($params=NULL){
	pr('test');
	pr($params);	
}



}	/* BlankController */
