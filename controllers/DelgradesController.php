<?php

Class DelgradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;

	$q="SELECT * FROM {$dbo}.`00_contacts` WHERE id=1 LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	pr($row);
	

	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */



public function delSxnGrades($params){
	require_once(SITE.'functions/details.php');
	$crs 	= $params[0];
	$dbg 	= PDBG;
	$dbg 	= PDBG;
	$db=&$this->baseModel->db;
	
	$course	= getCourseDetails($db,$crs,$dbg);	
	$q = "
		DELETE FROM {$dbg}.`50_grades` WHERE `course_id` = '$crs'; 
		DELETE FROM {$dbg}.`50_activities` WHERE `course_id` = '$crs'; 
		DELETE FROM {$dbg}.`50_scores` WHERE `course_id` = '$crs'; 
		DELETE FROM {$dbg}.`50_stats` WHERE `course_id` = '$crs'; 	
	";
	// pr($q);exit;
	$db->query($q);	
	$crid = $course['crid'];
	$course_name = $course['name'];
	$url = "reports/ecr/$crid";
	$_SESSION['message'] = "$course_name Grades Deleted!";
	redirect($url);

}	/* fxn */







}	/* BlankController */
