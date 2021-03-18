<?php

Class UnitablesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
$dbo=PDBO;
	
	$data="Unitables";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function list(){
	pr("Unitables List");
	
	
}	/* fxn */











}	/* BlankController */
