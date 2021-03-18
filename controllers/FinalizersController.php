<?php

Class FinalizersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	echo "Finalizers";
	$this->view->render($data,'tests/index');

}	/* fxn */



public function closeAttendance($params){
	$dbo=PDBO;	
	$crid 	 		= $params[0];
	$sy	 			= isset($params[1])? $params[1]:DBYR;
	$qtr	 		= isset($params[2])? $params[2]:$_SESSION['qtr'];

	$db=&$this->model->db;
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = '1' WHERE `crid` = '$crid' LIMIT 1 ; ";
	$db->query($q);	
	$home=$_SESSION['home'];	
	flashRedirect($home,'Attendance finalized.');
	
}	/* fxn */


public function openAttendance($params){
	$dbo=PDBO;	
	$crid 	 		= $params[0];
	$ssy			= $_SESSION['sy'];
	$sy	 			= isset($params[1])? $params[1]:$ssy;
	$qtr	 		= isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = '0' WHERE `crid` = '$crid' LIMIT 1 ; ";
	$db->query($q);	
	$home=$_SESSION['home'];	
	flashRedirect($home,'Attendance opened.');
	
}	/* fxn */




public function closeCourse($params){
	$dbo=PDBO;	
	require_once(SITE."functions/locks.php");
	$db =& $this->model->db;
	$crid = $params[0];
	$crsid = $params[1];
	$ssy = $_SESSION['sy'];
	$sy	= $params[2];$qtr = $params[3];$rurl = isset($params[4])? $params[4] : '';
	$dbg  = VCPREFIX.$sy.US.DBG;

	lockCourse($db,$crsid,$qtr,$dbg);
	echo "<h3>";$this->view->shovel('homelinks'); echo "</h3>";
	
}	/* fxn */


public function openCourse($params){
	$dbo=PDBO;	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/locks.php");
	$db =& $this->model->db;
	$crid = $params[0];$crsid = $params[1];
	$ssy = $_SESSION['sy'];$sy = $params[2];
	$qtr = $params[3];$rurl = isset($params[4])? $params[4] : '';
	$dbg  = VCPREFIX.$sy.US.DBG;
	/* 1- unlock Crs */
	unlockCourse($db,$crsid,$qtr,$dbg);
	/* 2 - check if has parent subject & delete if yes */
	$course = getCourseDetails($db,$crsid,$dbg);
	
	if($course['supsubject_id'] > 0){
		$subid = $course['supsubject_id'];
		$q = " SELECT id,name FROM {$dbg}.05_courses WHERE `subject_id` = '$subid' AND `crid` = '$crid' LIMIT 1;";
		$sth = $this->model->db->querysoc($q);
		$supcourse = $sth->fetch();
		unlockCourse($db,$supcourse['id'],$qtr,$dbg);
	} 
	
	/* 3 - unlock adviser_qtr */
	unlockClassroom($db,$crid,$qtr,$dbg);	
	echo "<h3>";$this->view->shovel('homelinks'); echo "</h3>";
	
}	/* fxn */


public function closeClassroom($params){
	$dbo=PDBO;	
	require_once(SITE."functions/locks.php");
	$db =& $this->model->db;
	$crid = $params[0];$ssy = $_SESSION['sy'];$sy	= $params[1];
	$qtr = $params[2];$rurl = isset($params[3])? $params[3] : '';
	$dbg = VCPREFIX.$sy.US.DBG;
	lockClassroom($db,$crid,$qtr,$dbg);
	redirect($rurl);	
}	/* fxn */


public function openClassroom($params){
	$dbo=PDBO;	
	require_once(SITE."functions/locks.php");
	$db =& $this->model->db;
	$crid = $params[0];$ssy = $_SESSION['sy'];$sy = $params[1];
	$qtr = $params[2];$rurl = isset($params[3])? $params[3] : '';
	$dbg = VCPREFIX.$sy.US.DBG;
	unlockClassroom($db,$crid,$qtr,$dbg);
	redirect($rurl);	
}	/* fxn */


// conduct same as attd at adv-qtrs
public function closeConduct($params){
	$dbo=PDBO;	
	$crid 	 		= $params[0];
	$sy	 			= isset($params[1])? $params[1]:DBYR;
	$qtr	 		= isset($params[2])? $params[2]:$_SESSION['qtr'];

	$db=&$this->model->db;
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `conduct_q$qtr` = '1' WHERE `crid` = '$crid' LIMIT 1 ; ";
	$db->query($q);	
	$home=$_SESSION['home'];	
	flashRedirect($home,'Conduct finalized.');
	
}	/* fxn */


public function openConduct($params){
	$dbo=PDBO;	
	$crid 	 		= $params[0];
	$ssy			= $_SESSION['sy'];
	$sy	 			= isset($params[1])? $params[1]:$ssy;
	$qtr	 		= isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `conduct_q$qtr` = '0' WHERE `crid` = '$crid' LIMIT 1 ; ";
	$db->query($q);	
	$home=$_SESSION['home'];	
	flashRedirect($home,'Conduct opened.');
	
}	/* fxn */





}	/* FinalizersController */
