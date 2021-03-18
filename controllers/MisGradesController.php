<?php

Class MisGradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){

	$data=NULL;	
	$this->view->render($data,'misgrades/indexMisGrades');
}	/* fxn */











}	/* BlankController */
