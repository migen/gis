<?php

Class ApicController extends Controller{	



public function __construct(){
	parent::__construct();			
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){	
	$dbo=PDBO;$db=&$this->baseModel->db;
		

	$data="ABC";$this->view->render($data,"abc/index");
	
}	/* fxn */


public function contacts(){
	header("Access-Control-Allow-Origin: * "); 
	header("Content-Type: application/json");
	
	$dbo=PDBO;$db=&$this->baseModel->db;
	$q="SELECT id,name AS login,code,name FROM {$dbo}.00_contacts WHERE role_id=1 ORDER BY id DESC LIMIT 5; ";		
	// pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['message']="Traversy Rest API";
	$data['rows']=$rows;
	echo json_encode($rows);	
	// return json_encode($rows);
	
	
}


}	/* BlankController */
