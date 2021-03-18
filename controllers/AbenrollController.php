<?php

Class AbenrollController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;

	$data=NULL;
	$this->view->render($data,"abenroll/indexEnrollment");
	

}	/* fxn */

public function migrate(){
	$db_from="aa_csv";
	$db_to="aa_enrollments";
	$dbo=PDBO;$db=&$this->baseModel->db;

	$q="
		UPDATE {$dbo}.$db_from AS a
		LEFT JOIN {$dbo}.$db_to AS b ON a.scid=b.scid
		WHERE b.sy=2019
		SET b.balance=a.amount
		;
	";
	pr($q);
	
	
}	/* fxn */






}	/* BlankController */
