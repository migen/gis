<?php

Class SummextController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function syncCrid($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/syncSummaries.php');
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	syncSummextByClassroom($db,$dbg,$crid);

}	/* fxn */




}	/* BlankController */
