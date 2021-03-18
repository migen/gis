<?php

Class PaydatesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$db=&$this->baseModel->db;$dbg=PDBG;$data="paydates";	
	// $this->view->render($data,"unisubjects/indexUnisubjects");
}	/* fxn */



public function edit($params=NULL){
	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;

	if(!isset($params[0])){ echo "ID NOT set."; exit; }
	$data['pkid']=$pkid=$params[0];
	$data['row']=$row=fetchRow($db,"{$dbo}.03_paydates",$pkid);
	$sy=$row['sy'];
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbo}.`03_paydates`",$post,"id='$pkid'");
		flashRedirect("enrollment/paydates/$sy","Saved.");
	}	/* post */
	
	$this->view->render($data,"paydates/editPaydate");
	
}	/* fxn */



}	/* BlankController */
