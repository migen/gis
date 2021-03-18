<?php

Class AbcController extends Controller{	


public function __construct(){
	parent::__construct();		
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
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;
	
	
	$this->view->render($data,"abc/index");

}	/* fxn */



public function passdiv(){
		
	$data=NULL;
	$this->view->render($data,"abc/passdiv");
}


public function css($params=NULL){	
	$db=&$this->baseModel->db;
	$data=NULL;	
	$this->view->render($data,"abc/css");

}	/* fxn */









public function scripts(){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=DBYR;
	
	$dbg=PDBG;
	// replaceComponentsCriteriaId	
	$q1="
		UPDATE {$dbg}.05_components 
		SET criteria_id=81 WHERE criteria_id=2;
	";	
	pr($q);


	// updateComponentsWeightByCriteriaId
	$q2="
		UPDATE {$dbg}.05_components 
		SET weight=20 WHERE criteria_id=4;
	";	
	pr($q2);

	
	
	$this->view->render($data,"abc/test");
}	/* fxn */



public function jsEvent(){
	$data=NULL;
	$this->view->render($data,"abc/jsEvent","basic");
	
	
}












}	/* BlankController */
