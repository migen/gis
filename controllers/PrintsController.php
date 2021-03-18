<?php

Class PrintsController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	// $this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');


	
}	/* fxn */


public function index($params=NULL){	
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;
	
	pr("prints");
	
	
	
	
	// $this->view->render($data,"prints/indexPrints");

}	/* fxn */


public function paper(){
		
	$data=NULL;

	$this->view->render($data,"prints/paperPrints","empty");
	
	
}	/* fxn */



}	/* BlankController */
