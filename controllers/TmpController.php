<?php

/* crscfg, */
Class MatrixController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}

public function index(){
	echo "matrix index homepage ";

}	/* fxn */



/* param2[0] course_id,param2[1] = qtr (default current setting)  */
public function custom($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classlist.php");
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	$db =& $this->model->db;

	$data['home']	= $_SESSION['home'];
	$data['user']	= $user = $_SESSION['user'];
	$crid 	 = $data['crid']	= $params[0];	
	$ssy 	 = $_SESSION['sy'];
	$sy 	 = $data['sy'] 		= isset($params[1])? $params[1] : $ssy;
	$qtr 	 = $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$data['srid']	= $srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD);
	$data['admin'] = $admin = in_array($srid,$adroles)? true:false;
	
	$cr = $data['classroom']  		= getClassroomDetails($db,$crid,$dbg);	
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	
	$data['is_locked']	=	$is_locked  	= $cr['is_finalized_q'.$qtr];
	$data['trait']		= getClassroomConductCourse($db,$dbg,$crid,CTYPETRAIT);
	$data['conduct']	= getClassroomConductCourse($db,$dbg,$crid,CTYPECONDUCT);

	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.="c.is_male DESC,c.name";
	$fields = "sum.id AS sumid,c.parent_id AS pcid,";
	$filter=null;$limits=null;$active=false;
	$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);			
	$data['num_students'] = count($data['students']);
	$data['courses'] 	  = matrixSubjects($db,$dbg,$crid,$fields=NULL);		
	$data['num_courses']  = count($data['courses']);
	$tcid   		 	  = $_SESSION['user']['ucid'];
	$grades = array();
	foreach($students AS $row){ $grades[] = matrixGrades($db,$dbg,$row['scid']); }
	$data['grades'] = $grades;
	
	/* attendance attd */
	$data['months'] = $months = attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] = $month_names = fetchRows($db,"{$dbo}.`05_months_quarters`",'*','`index`'," WHERE quarter = $qtr ");	
	$data['num_months'] = $num_months = count($data['month_names']);
	foreach($students AS $row){
		$attd[] = attendance($db,$dbg,$sy,$row['scid']); 			
	}		
	$data['attd'] = $attd;	
	$data['page'] = "Consolidated Grading Sheet - Quarter {$qtr}";	

	$vpath = SITE.'views/customs/'.VCFOLDER.'/cmatrix.php';		
	if(is_readable($vpath)){
		$vfile="/customs/".VCFOLDER."/cmatrix";	
	} else {
		$vfile="matrix/grades";		
	}
	$this->view->render($data,$vfile);

} 	/* fxn */



/* param2[0] course_id,param2[1] = qtr (default current setting)  */
public function grades($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classlist.php");
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	

	$data['home']	= $_SESSION['home'];
	$data['user']	= $user = $_SESSION['user'];
	$crid 	 = $data['crid']	= $params[0];	
	$ssy 	 = $_SESSION['sy'];
	$sy=isset($params[1])? $params[1] : $ssy;
	$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	
	$data['sy']=$sy;
	$data['qtr']=$qtr;
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

	
	$data['srid']	= $srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD);
	$data['admin'] = $admin = in_array($srid,$adroles)? true:false;
	
	$cr=$data['classroom']=getClassroomDetails($db,$crid,$dbg);	
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	
	$data['is_locked']=$is_locked=$cr['is_finalized_q'.$qtr];
	$data['trait']=getClassroomConductCourse($db,$dbg,$crid,CTYPETRAIT);
	$data['conduct']=getClassroomConductCourse($db,$dbg,$crid,CTYPECONDUCT);

	$order=$_SESSION['settings']['classlist_order'];
	$order= (isset($_GET['sort']))? $_GET['sort']:$order;	
	$fields = "sum.id AS sumid,c.parent_id AS pcid,";
	$filter=null;$limits=null;$active=false;
	$order="c.name";
	$data['students']=$students=classSummaries($db,$dbg,$crid,$male=2,$order,$fields,$filter,$limits,$active);		
		
	$q=$_SESSION['q'];	
	$sem=isset($_GET['sem'])?$_GET['sem']:0;
	$data['num_students']=count($data['students']);
	$data['courses']=matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter=NULL,$sem);	
	debug($q,"BonuxFxn: matrix subjects ");		
	$data['num_courses']=count($data['courses']);
	$tcid=$_SESSION['user']['ucid'];
	$grades=array();
	foreach($students AS $row){ $grades[]=matrixGrades($db,$dbg,$row['scid'],$filter=NULL,$sem); }	
	$q.="<br />Bonuses Fxn: Matrix Grades<br />".$_SESSION['q'];
	$data['q']=$q;
	$data['grades'] = $grades;
	
	/* attendance attd */
	$data['months'] = $months = attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] = $month_names = fetchRows($db,"{$dbo}.`05_months_quarters`",'*','`index`'," WHERE quarter = $qtr ");	
	$data['num_months'] = $num_months = count($data['month_names']);
	foreach($students AS $row){
		$attd[] = attendance($db,$dbg,$sy,$row['scid']); 			
	}		
	
	$attd=isset($attd)? $attd:NULL;
	$data['attd'] = $attd;	
	$data['page'] = "Consolidated Grading Sheet - SY".$sy." Q{$qtr}";	

	$vpath = SITE.'views/customs/'.VCFOLDER.'/matrix.php';		
	if(is_readable($vpath)){ $vfile="/customs/".VCFOLDER."/matrix";	
	} else { $vfile="matrix/gradesMatrix"; }

	
	$this->view->render($data,$vfile);

} 	/* fxn */



public function attd($params){
$dbo=PDBO;
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	
	$data['crid']=$crid=$params[0];	
	$ssy=$_SESSION['sy'];	
	$sy=$data['sy']=isset($params[1])?$params[1]:DBYR;	
	$qtr=$data['qtr']=isset($params[2])?$params[2]:$_SESSION['qtr'];	
	$home=$data['home']=$_SESSION['home'];
	$current=$data['current']=($sy==$ssy)? true:false;	
	$db=& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;	
	
	/* is_locked = advisers_quarters.attendance_q# */
	$cr = $data['classroom']  = getClassroomDetails($db,$crid,$dbg);	
	if($qtr < 5){ 	$data['is_locked'] = ($cr['attendance_q'.$qtr]==1)? true:false; }	
	$months = $data['months_quarters'] = gisMonthsQuarters($db,$qtr);
 	 

/* ---------------------- process ---------------------------------------------------------------- */	
	
	$order="c.is_male DESC,c.name";
	$fields="c.attschema_id,";
	$filter=null;$limits=null;$active=false;
	$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);			
	$data['num_students'] = count($data['students']);		
	$data['count']=$data['num_students'];
	$data['attendance_months'] 	= getAttendanceMonths($db,$cr['level_id'],$sy,$dbg);	 	 
	foreach($data['students'] AS $row){ $data['attendance'][] = getStudentAttendance($db,$dbg,$sy,$row['scid']); }
	$data['today']		= $_SESSION['today'];
	$data['crid']		= $crid;
	
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
	$_SESSION['crid'] = "$crid";	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms");
	
	// $type=($_SESSION['settings']['attd_qtr']==1)? 'qtr':'month'; 
	$vfile=($_SESSION['settings']['attd_qtr']==1)? 'matrix/attdqtr':'matrix/attd'; 
	$data['rows']=$data['attendance']; 

	$this->view->render($data,$vfile);

} 	/* fxn */



public function attdQtr($params){
$dbo=PDBO;
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	$db =& $this->model->db;

	$data['crid'] = $crid = $params[0];	
	$ssy		= $_SESSION['sy'];
	
	// $sy 		= $data['sy'] = $_SESSION['sy'];
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$home 		= $data['home']	= $_SESSION['home'];
	$current	= $data['current']	= ($sy==$ssy)? true:false;
	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	/* is_locked = advisers_quarters.attendance_q# */
	$cr = $data['classroom']  = getClassroomDetails($db,$crid,$dbg);	
	// pr($cr);
	if($qtr < 5){ 	$data['is_locked'] = ($cr['attendance_q'.$qtr]==1)? true:false; }
	
	$months = $data['months_quarters'] = gisMonthsQuarters($db,$qtr);
 	 
		

/* ---------------------- process ---------------------------------------------------------------- */	
	
	$order=$_SESSION['settings']['classlist_order'];
	$fields="c.attschema_id,";$filter=null;$limits=null;$active=false;
	$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);	
		
	$data['num_students'] = count($data['students']);		
	$data['count']=$data['num_students'];
	$data['attendance_months'] 	= getAttendanceMonths($db,$cr['level_id'],$sy,$dbg);	 	 
	foreach($data['students'] AS $row){ $data['rows'][] = getStudentAttendance($db,$dbg,$sy,$row['scid']); }
	$data['today']		= $_SESSION['today'];
	$data['crid']		= $crid;
	
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
	$_SESSION['crid'] = "$crid";	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms");
			
	$this->view->render($data,'matrix/attdQtr');

} 	/* fxn */







} 	/* MatrixController */
