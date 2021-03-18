<?php

Class EdtrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	
	require_once(SITE."functions/edtrFxn.php");
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$today=$_SESSION['today'];	

	if(isset($_POST['submit'])){
		/* 1 */
		pr($_POST);
		$post=$_POST;		
		edtrLogin($db,$dbg,$post);
				
		
		exit;
		
	}

	
	$data=NULL;
	$this->view->render($data,'edtr/indexEdtr');

}	/* fxn */







}	/* BlankController */
