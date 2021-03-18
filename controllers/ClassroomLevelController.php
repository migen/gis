<?php

Class ClassroomLevelController extends Controller{	


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


    if(!isset($_SESSION['classrooms'])){ 	
        $_SESSION['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","id,name,acid AS acid","level_id"); } 
        $data['classrooms'] 	= $_SESSION['classrooms'];	
    if(!isset($_SESSION['levels'])){ 	
        $_SESSION['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,name,department_id AS deptid","id"); }
        $data['levels'] 	= $_SESSION['levels'];	
        

	
	$this->view->render($data,"classroomLevel/indexClassroomLevel");

}	/* fxn */
















}	/* BlankController */
