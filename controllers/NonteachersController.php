<?php

Class NonteachersController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index($params=NULL){
	$dbo=PDBO;$db =& $this->baseModel->db;
	require_once(SITE."functions/miscontacts.php");
	include_once(SITE.'views/elements/params_sq.php');
	$sort = isset($_GET['sort'])? $_GET['sort']:'c.name';
	$order = isset($_GET['order'])? $_GET['order']:'ASC';	
	$data['rows'] = getNonteachers($db,$sort,$order);		
	$data['count']	= count($data['rows']);		
	$this->view->render($data,'mis/nonteachers');

}	/* fxn */




}	/* BlankController */
