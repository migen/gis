<?php

Class VersionsController extends Controller{	

public function __construct(){
	parent::__construct();		
	// $this->beforeFilter();

	
}

public function beforeFilter(){
	// $this->view->css=array('style_long.css');
	// $this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}


public function index(){
	$data['vcprefix']=VCPREFIX;
	$data['dbone']=PDBO;
	$data['dbgis']=PDBG;
	$this->view->render($data,"versions/indexVersion");	
}


public function v5(){
	$data=NULL;
	$this->view->render($data,"versions/indexVersion");		
}	/* fxn */




}	/* BlankController */
