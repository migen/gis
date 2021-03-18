<?php

Class CreditsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;

	echo "DBO: ".PDBO."<br />";
	echo "PDBG: ".PDBG."<br />";

	echo "<br /><a href='".URL."' >Home</a>";
	
	

}	/* fxn */




}	/* BlankController */
