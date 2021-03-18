<?php

Class AzController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;
	$dbg=PDBG;$db=&$this->baseModel->db;

	$q="SELECT * FROM {$dbg}.00_ztests; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
	
	

}	/* fxn */




}	/* BlankController */
