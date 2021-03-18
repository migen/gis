<?php

Class ArchqueriesController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function query(){	
$db=&$this->baseModel->db;$dbg=PDBG;


}	/* fxn */



}	/* BlankController */
