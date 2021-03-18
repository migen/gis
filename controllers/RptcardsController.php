<?php

Class RptcardsController extends Controller{	

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
	// require_once(SITE."functions/encryptionFxn.php");
	// $this->view->render($data,"records/complexRecords");
	

}	/* fxn */



public function crid($params=NULL){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$data['crid']=$crid=isset($params[0])? $params[0]:1;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['tpl']=$tpl=isset($_GET['tpl'])? $_GET['tpl']:2;
	pr($data);


}	/* fxn */



public function scid($params=NULL){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$data['scid']=$scid=isset($params[0])? $params[0]:1;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['tpl']=$tpl=isset($_GET['tpl'])? $_GET['tpl']:2;
	pr($data);



}	/* fxn */






}	/* BlankController */
