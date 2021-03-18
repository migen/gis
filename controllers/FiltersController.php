<?php

Class FiltersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js','js/vegas_extra.js');
	// parent::beforeFilter();			
}



public function index(){
	$data=NULL;
	if(isset($_POST['submit'])){
		pr($_POST);
	}
	
	$this->view->render($data,'filters/indexFilters');
}





}	/* BlankController */
