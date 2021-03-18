<?php

Class IntegersController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	// parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */






public function index($params=NULL){	

	pr("Integers");

}	/* fxn */

public function ordinal(){	
	$db=&$this->baseModel->db;
	$dbo=PDBO;$data['sy']=DBYR;$dbg=PDBG;
	
	require_once(SITE.'functions/numberFxn.php');
	
	$this->view->render($data,"integers/ordinal");

}	/* fxn */














}	/* BlankController */
