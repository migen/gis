<?php

Class ToolslinksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index(){
	$dbo=PDBO;	
	$data['sy']=DBYR;$data['qtr']=$_SESSION['qtr'];
	$vfile='toolslinks/indexToolslinks';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


}	/* BlankController */
