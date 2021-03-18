<?php

Class ColumnsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT * FROM {$dbo}.`00_contacts` WHERE id<3000 LIMIT 30; ";
	$sth=$db->querysoc($q);
	debug($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	$this->view->render($data,'columns/indexColumns');
}	/* fxn */






}	/* BlankController */
