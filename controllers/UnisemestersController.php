<?php

Class UnisemestersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){		
	$data['page']="College Semesters";
	$data['summer_semester']=9;
	$this->view->render($data,'abc/defaultAbc');
	
	
}	/* fxn */




}	/* BlankController */
