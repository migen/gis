<?php

Class UniadvisersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Uniadvisers";	
	$this->view->render($data,"uniadvisers/indexUniadvisers");
}	/* fxn */


public function all(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT cr.*,cr.id AS crid,c.name AS adviser
		FROM {$dbg}.01_classrooms AS cr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		ORDER BY cr.major_id,cr.section_id;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"uniadvisers/allUniadvisers");
	
}	/* fxn */











}	/* BlankController */
