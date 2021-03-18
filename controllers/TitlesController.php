<?php

Class TitlesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	$data['titles']		= $this->model->titlesDetails($dbg);		
	$data['num_titles']		= count($data['titles']);
	$this->view->render($data,'titles/index');		


}	/* fxn */







}	/* TitlesController */
