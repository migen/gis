<?php

Class StylesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$data=NULL;$this->view->render($data,'styles/indexStyles');
	
}	/* fxn */

}	/* BlankController */
