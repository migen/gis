<?php

Class BlockController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	$data="Block";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function courses($params){
	$dbo=PDBO;
	// require_once(SITE.'functions/blockFxn.php');
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	$q="SELECT
			c.id AS crs,c.name AS course,
			s.id AS sub,s.name AS subject
		FROM {$dbg}.05_courses AS c
		INNER JOIN {$dbg}.05_classrooms AS cr ON c.crid=cr.id
		INNER JOIN {$dbo}.`05_subjects` AS s ON c.subject_id=s.id
		WHERE c.crid='$crid';		
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"block/coursesBlock");
	
}	/* fxn */








}	/* BlankController */
