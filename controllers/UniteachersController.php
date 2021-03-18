<?php

Class UniteachersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	$dbo=PDBO;

	// $data="Uniteachers";	
	$db=$this->baseModel->db;$dbg=PDBG;
	$has_college=$_SESSION['settings']['has_college'];
	pr($has_college);
	
	
	
	$this->view->render($data,'uniteachers/indexUniteachers');
	
	
	
}	/* fxn */











}	/* BlankController */
