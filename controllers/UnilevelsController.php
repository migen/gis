<?php

Class UnilevelsController extends Controller{	

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
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT * FROM {$dbg}.01_levels ORDER BY `id`; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"unilevels/setUnilevels");
}	/* fxn */











}	/* BlankController */
