<?php

Class McrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	 	
	parent::beforeFilter();			
}


public function index(){ echo "McrController index"; }	/* fxn */


private function getMcrData($params){
	$dbo=PDBO;
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	$db =& $this->baseModel->db;

	$data['crid']	= $crid = 	$params[0];	
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : DBYR;	
	$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$data['param_qtr']=$qtr;

	/* controller - teachers or else */
	$data['home']	=	$home = $_SESSION['home']; 			

/* ------------------------------------------------------------------------------------------------- */		
	
	$order = " c.is_male DESC,c.name "; 
	if($home=='teachers'){ 
		if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } 
		$sy 	= $data['sy']  = $_SESSION['sy'];		
		$qtr 	= $data['qtr'] = $_SESSION['qtr'];		

	} 

	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);			
	
	
	$data['sem']			= $sem			= isset($_GET['sem'])? $_GET['sem']: false;	
	$data['derivsem']		= ($qtr<3)? 1:2;
	
	$fields="sx.*,";
	$data['students'] 	= classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);			
	
	
	$data['num_students'] 	= count($data['students']);
	$electives = NULL;	
	$sub_electives = NULL;
	
	$cfilter = ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;		
	$data['subjects'] 	  = matrixSubjects($db,$dbg,$crid,$fields=NULL,$cfilter);		
	$data['num_subjects'] 	= count($data['subjects']);		

	foreach($data['students'] AS $row){ $data['grades'][] = matrixGrades($db,$dbg,$row['scid'],$cfilter); }	


	
	
	/* variables for view,a) classroom info b) course links control */	
	$data['classrooms']		= fetchRows($db,"{$dbg}.05_classrooms","*","level_id");	
	$data['is_locked']		= ($qtr<5)? $data['classroom']['is_finalized_q'.$qtr]:$data['classroom']['is_finalized_q4'];
	$data['user']			= $_SESSION['user'];

	$admins = array(RMIS,RREG); 		
	$srid = $_SESSION['user']['role_id']; 
	$data['is_admin'] = (in_array($srid,$admins))? true:false;	
	
	return $data;
	
}	/* fxn */


public function view($params){
	$data=$this->getMcrData($params);
	$vfile="mcr/viewMcr";vfile($vfile);
	$this->view->render($data,$vfile);		

}	/* fxn */



public function sem($params){
	$data=$this->getMcrData($params);
	$vfile="mcr/semMcr";vfile($vfile);
	$this->view->render($data,$vfile);		
	
}	/* fxn */
















}	/* ReportsController */
