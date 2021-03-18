<?php

Class RfidController extends Controller{	

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
	$dbo=PDBO;

	
	$data=NULL;
	$this->view->render($data,'rfid/indexRfid');
	
}	/* fxn */

public function read(){
	$data=NULL;
	$this->view->render($data,"rfid/readRfid");
}	/* fxn */


public function one($params=NULL){	
	$data=NULL;
	$this->view->render($data,"rfid/oneRfid");
	
}	/* fxn */



}	/* BlankController */
