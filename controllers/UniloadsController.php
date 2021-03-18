<?php

Class UniloadsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="ABC";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function tcid($params=NULL){
	$data['tcid']=$tcid=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	$q="SELECT crs.name AS course,crs.id AS crs,sub.name AS subject,crs.*
		FROM {$dbg}.01_courses AS crs 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id 
		WHERE crs.tcid=$tcid ORDER BY crs.name;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"uniloads/tcidUniloads");
	
}	/* fxn */











}	/* BlankController */
