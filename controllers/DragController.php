<?php

Class DragController extends Controller{	

public function __construct(){
	parent::__construct();		
	// $this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	// dbo.prodtypes-id,name,position,color	
	$db=$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.prodtypes ORDER BY position; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"drag/indexDrag","blank");

	
}	/* fxn */




}	/* BlankController */
