<?php

Class TmpGradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	pr("Tmp Grades");
	// $data=array('car','house');
	// $data=NULL;	
	// $this->view->render($data,'abc/indexAbcxxx');
	// $this->view->render($data,'abc/indexAbc');
}	/* fxn */


public function crNumToMajor(){
$dbo=PDBO;
	$db=$this->baseModel->db;$dbg=PDBG;
	$q="UPDATE {$dbg}.05_classrooms SET major_id=num; ";
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	}
	
	$data=NULL;
	$this->view->render($data,"abc/defaultAbc");
}	/* fxn */


}	/* BlankController */
