<?php

Class FontController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`00_contacts` LIMIT 10; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=count($data['rows']);
	$this->view->render($data,'font/indexFont');

}	/* fxn */




}	/* BlankController */
