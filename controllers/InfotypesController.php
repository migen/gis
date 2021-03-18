<?php

Class InfotypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$db=&$this->model->db;$dbo=PDBO;
	$data['rows']=fetchRows($db,"{$dbo}.infotypes","*","name");
	$data['count']=count($data['rows']);
	$this->view->render($data,'infotypes/index');

}	/* fxn */









}	/* InfotypesController */
