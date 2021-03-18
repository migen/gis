<?php

Class ModalController extends Controller{	

public function __construct(){
	parent::__construct();		
	// $this->beforeFilter();	
}	/* fxn */

public function beforeFilter(){
	parent::beforeFilter();
}	/* fxn */




public function index(){
	$data=("Modal");
	
	$this->view->render($data,'modal/indexModal',"empty");
}	/* fxn */



public function pages(){
$dbo=PDBO;
	// $data=("Pages");pr($data);
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT id,name FROM {$dbo}.`00_contacts` WHERE role_id=1 ORDER BY name LIMIT 30; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	
	$this->view->render($data,'modal/pagesModal');
}	/* fxn */






}	/* BlankController */
