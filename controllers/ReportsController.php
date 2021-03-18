<?php

Class ReportsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	 	
	parent::beforeFilter();			
}


public function index(){ echo "ReportsController index"; }	/* fxn */

public function rcr($params){
$dbo=PDBO;
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$data['crid']	= $crid = 	$params[0];	
	$data['ssy']	= $ssy  = $_SESSION['sy'];
	$data['sqtr']	= $sqtr = $_SESSION['qtr'];	
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;	
	$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $sqtr;	
	

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
	$data['sem']			= $sem			= isset($params[3])? $params[3]: $classroom['is_sem'];	
	$data['derivsem']		= ($qtr<3)? 1:2;

	$fields="sx.rank_classroom_q{$qtr},sx.rank_classroom_q5,";
	$data['students'] 	= classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);			
	
	
	$data['num_students'] 	= count($data['students']);
	$electives = NULL;	
	$sub_electives = NULL;
	
	$cfilter = ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;	
	$data['subjects'] 	  = matrixSubjects($db,$dbg,$crid,$fields=NULL,$cfilter);		
	$data['num_subjects'] 	= count($data['subjects']);		
	foreach($data['students'] AS $row){ $data['grades'][] = matrixGrades($db,$dbg,$row['scid'],$cfilter); }	

	/* variables for view,a) classroom info b) course links control */	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['is_locked']		= ($qtr<5)? $data['classroom']['is_finalized_q'.$qtr]:$data['classroom']['is_finalized_q4'];
	$data['user']			= $_SESSION['user'];
	
	$this->view->render($data,'registrars/rcr');		
	
}	/* fxn */

public function mcr($params){
$dbo=PDBO;
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$data['crid']	= $crid = 	$params[0];	
	$data['ssy']	= $ssy  = $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;	
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
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['is_locked']		= ($qtr<5)? $data['classroom']['is_finalized_q'.$qtr]:$data['classroom']['is_finalized_q4'];
	$data['user']			= $_SESSION['user'];

	$admins = array(RMIS,RREG); 		
	$srid = $_SESSION['user']['role_id']; 
	$data['is_admin'] = (in_array($srid,$admins))? true:false;
	$this->view->render($data,"mcr/view");		
	
}	/* fxn */

public function ccr($params){
$dbo=PDBO;
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");	
	$data['crid']=$crid=$params[0];	
	$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;	
	$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];	

	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;	
	
	/* controller - teachers or else */
	$data['home']=$home=$_SESSION['home']; 				
	$row=getClassroomConductCourseId($db,$crid);
	$data['conduct_course_id'] = $conduct_course_id = $row['course_id'];
	$admins = array(RMIS,RREG); 		
	$srid = $_SESSION['user']['role_id']; 
	$data['is_admin'] = (in_array($srid,$admins))? true:false;
		
/* ------------------------------------------------------------------------------------------------- */		
	
	$order = " c.is_male DESC,c.name "; 
	if($_SESSION['srid']==RTEAC){ 
		if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } 	
		$data['sy']=$sy=DBYR;		
		$data['qtr']=$qtr=($qtr==5)?$qtr:$_SESSION['qtr'];		
	} 
	
	$data['students']=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields="sx.rank_classroom_q{$qtr},");				
	
	if(!isset($_GET['sem'])){
		$sem=0;
	} else {
		$sem=$_GET['sem'];
	}	
	$data['sem'] = $sem;
	$filter="";
	if($sem){
		$filter .= " AND (crs.semester=$sem) ";
	}
	
	$data['num_students'] 	= count($data['students']);
	$data['subjects'] 	  = matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter);	
	$data['num_subjects'] 	= count($data['subjects']);			
	foreach($data['students'] AS $row){ $data['grades'][] = matrixGrades($db,$dbg,$row['scid'],$filter); }	

	/* variables for view,a) classroom info b) course links control */
	$data['classroom']		= getClassroomDetails($db,$crid,$dbg);			
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['is_locked']		= $data['classroom']['is_finalized_q'.$qtr];
	$data['user']			= $_SESSION['user'];
		
	$this->view->render($data,'reports/ccr');		
	
}	/* fxn */

/* param2[0] course_id,param2[1] = qtr (default current setting)  */
public function ecr($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");	
	require_once(SITE."functions/classlist.php");
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/equivs.php");
	$db =& $this->model->db;
	
	$data['home']	= $home = $_SESSION['home'];
	$crid 	 = $data['crid']	= $params[0];	
	$ssy 	 = $_SESSION['sy'];
	$sy 	 = $data['sy'] 		= isset($params[1])? $params[1] : $ssy;
	$qtr 	 = $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];

	$_SESSION['url'] = "reports/ecr/$crid/$sy/$qtr";
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['save'])){
		$rows = $_POST['g'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbg}.50_grades SET 
				`q{$qtr}` = '".$row['gx']."',`dg{$qtr}` = '".$row['dgx']."' 
				WHERE `id` = '".$row['gid']."' LIMIT 1; ";
		}
		// pr($q);exit;
		$db->query($q);
		$url = $_SESSION['url'];
		redirect($url);
		exit;
	}
	
	
	$allowed_roles = array(RMIS,RREG); 
	if(!in_array($_SESSION['srid'],$allowed_roles)){ $this->flashRedirect($home); }
		
	$cr = $data['classroom']  		= getClassroomDetails($db,$crid,$dbg);	
	$data['is_locked']	=	$is_locked  	= ($qtr<5)? $cr['is_finalized_q'.$qtr]:$cr['is_finalized_q4'];	

	
	$order="c.is_male DESC,c.name";
	$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order);	
	
	
	$data['num_students'] = count($data['students']);
	$data['courses'] 	  = matrixSubjects($db,$dbg,$crid,$fields=NULL);	
	$data['num_courses']  = count($data['courses']);
	$tcid   		 	  = $_SESSION['user']['ucid'];

	$crClass		 	= classifyClass($data['classroom']);
	$data['ratings'] 	= getRatings($db,$ctype=1,$crClass['dept_id']);		
	
	$grades = array();
	foreach($students AS $row){ $grades[] = matrixGrades($db,$dbg,$row['scid']); }
	$data['grades'] = $grades;

	$this->view->render($data,'reports/ecr');

} 	/* fxn */


















}	/* ReportsController */
