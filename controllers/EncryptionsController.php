<?php

Class AbcController extends Controller{	

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
	require_once(SITE."functions/encryptionFxn.php");
	$string="pass";
	$action="encrypt";
	$enc=encrypt_decrypt($action, $string);
	pr($enc);
	
	$string=$enc;
	$action="decrypt";
	$dec=encrypt_decrypt($action, $string);
	pr($dec);



	// $this->view->render($data,"records/complexRecords");
	

}	/* fxn */






}	/* BlankController */
