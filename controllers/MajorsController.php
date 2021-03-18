<?php

Class MajorsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}


public function index(){
	
	$dbg=PDBG;$dbo=PDBO;$db=&$this->baseModel->db;
	$order=isset($_GET['order'])? $_GET['order']:"name";
	$data['order']=&$order;
	$q="SELECT * FROM {$dbo}.`05_majors` ORDER BY $order;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,'majors/indexMajors');
	
	
}	/* fxn */







}	/* BlankController */
