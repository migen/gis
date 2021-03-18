<?php

Class BranchesController extends Controller{	

public $dbtable;

public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".00_branches`";	
	$this->beforeFilter();	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$dbo=PDBO;$db=&$this->baseModel->db;
/* 	if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
	$data['branches']=$_SESSION['branches'];
	$data['srid']=$_SESSION['srid'];
	if(!isset($_SESSION['brid'])){ $ucid=$_SESSION['ucid'];
		$row=fetchRow($db,"{$dbo}.`00_contacts`",$ucid,"id,branch_id");$_SESSION['brid']=$row['branch_id'];
	}
 */
 
	initSession($db,"brid");
 
 
	$data['brid']=$_SESSION['brid'];
	$data['branches']=$_SESSION['branches'];
	
	if(isset($_POST['submit'])){
		pr($_POST);
		exit;
		
	}
	
	$this->view->render($data,"branches/indexBranches");

}	/* fxn */





}	/* BlankController */
