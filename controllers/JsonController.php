<?php

Class JsonController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Json ";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function levels(){
	$dbo=PDBO;	
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT id,code,name FROM {$dbo}.`05_levels`;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	// pr($rows);
	echo json_encode($rows);
	echo "<hr />";
	$x=json_encode($rows);
	pr($x);
	echo "<hr />";
	$data['levels']=json_encode($rows);
	pr($data);
	
	
}	/* fxn */




public function level($params=NULL){
	$dbo=PDBO;	
	$db=&$this->baseModel->db;$dbg=PDBG;
	$lvl=isset($params[0])? $params[0]:4;
	$q="SELECT id,code,name FROM {$dbo}.`05_levels` WHERE id='$lvl' LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$x=json_encode($row);
	// pr($x);
	echo "<pre>";
	pr($x);
	echo "</pre>";
	
}	/* fxn */









}	/* BlankController */
