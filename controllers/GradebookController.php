<?php

Class GradebookController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index($params=NULL){

// $this->view->render($data,'abc/index');

}	/* fxn */



/* creports,sync with GSController/reportCard */
public function classroom($params){	
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/quartersFxn.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/ratings.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/photos.php");
	
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];

	$current=($sy==DBYR)? true:false; 	
	$qtr=($current)? $qtr:4;	
	$data['qtr']=$qtr;
	$db=&$this->model->db;$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;	
	$data['user']= $user=$_SESSION['user'];
	$title_id=$user['title_id'];	
	$role_id=$user['role_id'];	
	if(!(($role_id == RREG) || ($role_id == RMIS))) { $this->flashRedirect('index/unauth'); } 
		
	/* controller - teachers or else */
	$data['home'] =	$home = $_SESSION['home']; 			

/* -------------------------------------------------------------------------------------------- */		

	$_SESSION['gradebook']['crid'] 		= $crid; 			
	if(isset($_POST['filter'])){
		/* $sy		= isset($_POST['cf']['sy'])? $_POST['sy'] : $sy; */
		$crid= $_POST['cf']['crid'];
		$sy=$_POST['cf']['sy'];
		$_SESSION['gradebook']['crid'] 	= $crid; 
		$_SESSION['gradebook']['sy']  	= $sy;
		$url = 'gradebook/classroom/'.$crid.DS.$sy.DS.$qtr;				
		redirect($url);
	}	/* post-submit */
	
	
/* ----------------- process --------------------------------------------------------------------------- */		


$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order="c.`is_male` DESC,c.`name`",NULL,NULL,NULL,false);	

if($_SESSION['settings']['show_photos']==1){
$data['photos'] = getClassPhotos($db,$dbg,$sy,$crid,$male=2,$order="c.`is_male` DESC,c.`name`",NULL,NULL,NULL,false);	
}

	$data['num_students']	= $num_students = count($students);
	
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
	
	
	/* 1) grades,2) attendance,3) conducts,4) if applicable-psmapehs */
	
	for($i=0;$i<$num_students;$i++){		
		$students[$i]['summary'] 		= getStudentSummary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		/* @ library-GSModel */
		$students[$i]['grades'] 		= getStudentGrades($db,$dbg,$sy,$crid,$students[$i]['scid']); 		/* @ library-GSModel */
		$students[$i]['attendance'] 	= getStudentAttendance($db,$dbg,$sy,$students[$i]['scid']); 		
	}	/* for */ 

/* pr($classroom); */
if($classroom['conduct_ctype_id']==CTYPETRAIT){	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = getStudentTraits($db,$dbg,$sy,$students[$i]['scid']); }		
} else {	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = getStudentConducts($db,$dbg,$sy,$students[$i]['scid']); }				
}
	
	$data['students']=&$students;
	

/* ----------------- process --------------------------------------------------------------------------- */		
	
			
	$data['month_codes'] 	= getCodes($db,"{$dbo}.`05_months_quarters`");	
	$data['months'] 	 	= getAttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] 	= getQuarterMonths($db,$dbg);	
	$data['classrooms'] 	= fetchRows($db,"{$dbg}.05_classrooms","*","level_id");

	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	/* arm-Model */
	$data['courses_locked'] = $courses_locked;
	// echo "crs locked: "; pr($courses_locked); exit;

	$data['printable']	= true;
	if($current){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;
	
	$this->view->render($data,'gradebook/classroomGradebook');		

}	/* fxn */






}	/* BlankController */
