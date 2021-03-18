<?php

Class DtrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	
	require_once(SITE."functions/dtr.php");
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;$dbp=DBP;
	$today=$_SESSION['today'];	

	if(isset($_POST['submit'])){
		/* 1 */
		// pr($_POST);exit;
		$post=$_POST;
		dtrLogin($db,$post);
		redirect('dtr');
		exit;
		
	}

	
	$data=NULL;
	$this->view->render($data,'dtr/index');

}	/* fxn */





}	/* BlankController */
