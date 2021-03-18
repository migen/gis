<?php

Class TodoController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){  echo "Todo"; }

// TODO - sjam gradhonors

	


}	/* BlankController */
