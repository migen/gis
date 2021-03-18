<?php

Class CtypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`05_crstypes`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'ctypes/indexCtypes');
}	/* fxn */





}	/* BlankController */
