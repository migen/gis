<?php

Class ProfessorsController extends Controller{	

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
	$db=$this->baseModel->db;$dbg=PDBG;
	$data['has_college']=$has_college=$_SESSION['settings']['has_college'];	
	$data['srid']=$srid=$_SESSION['user']['role_id'];	

	if(!$has_college){ $_SESSION['message']="No College."; flashRedirect("",$msg); }

	if($has_college && $srid==RTEAC){
		require_once(SITE.'functions/sessionize.php');
		require_once(SITE.'functions/sessionize_professor.php');
		if(!isset($_SESSION['professor'])){
			$db=&$this->baseModel->db;$dbg=PDBG;
			sessionizeProfessor($db,$dbg);
			
		}
		
		
	}	/* sessionizeProfessor */
	
	

	$this->view->render($data,'professors/indexProfessors');
	
	
	
}	/* fxn */


public function reset(){
$dbo=PDBO;
	require_once(SITE.'functions/sessionize.php');
	require_once(SITE.'functions/sessionize_professor.php');
	$db=&$this->baseModel->db;$dbg=PDBG;
	sessionizeProfessor($db,$dbg);
	flashRedirect("professors","Professor session reset.");
		
	
	
}	/* fxn */








}	/* BlankController */
