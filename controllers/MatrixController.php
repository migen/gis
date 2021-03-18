<?php

/* crscfg, */
Class MatrixController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	// $this->view->css=array('style_long.css');
	$this->view->js = array('js/crypto.js','js/jquery.js','js/vegas.js');	
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
	$sy 	 = $data['sy'] 		= isset($params[1])? $params[1] : DBYR;
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
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/classlist.php");
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	
	$data['home']=$_SESSION['home'];
	$data['user']=$user=$_SESSION['user'];
	$crid=$data['crid']	=$params[0];	
	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['ssy']=&$ssy;
	$data['sqtr']=&$sqtr;
	$sy=isset($params[1])?$params[1]:DBYR;
	$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];	
	$data['sy']=$sy;$data['qtr']=$qtr;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['db']=&$db;$data['dbg']=&$dbg;
	
	$data['srid']	= $srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD,RTEAC);
	$data['admin'] = $admin = in_array($srid,$adroles)? true:false;
	
	$data['cr']=$cr=$data['classroom']=getClassroomDetails($db,$crid,$dbg);	
	$data['dept']=$dept=$cr['department_id'];
	$deptrow=getDepartmentArray($dept);
	$data['deptcode']=$deptcode=strtolower($deptrow['dept_code']);
	
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	if($srid==RTEAC and !$adviser){ if($_SESSION['user']['privilege_id']>0){ flashRedirect($home); } }
	if($_SESSION['settings']['has_branches']==1){
		$data['brid']=$brid=$cr['branch_id'];
		$br_row=fetchRow($db,"{$dbo}.`00_branches`",$brid);
		$data['brcode']=$br_row['code'];
		$data['branch']=$br_row['name'];	
		$data['lc_brcode']=strtolower($data['brcode']);		
	} else {
		
	}
	
	$data['is_locked']=$is_locked=$cr['is_finalized_q'.$qtr];
	$data['trait']=getClassroomConductCourse($db,$dbg,$crid,CTYPETRAIT);
	$data['conduct']=getClassroomConductCourse($db,$dbg,$crid,CTYPECONDUCT);

	$order=$_SESSION['settings']['classlist_order'];
	$order= (isset($_GET['sort']))? $_GET['sort']:$order;	
	$fields = "sum.id AS sumid,c.parent_id AS pcid,";
	$filter=null;$limits=null;$active=false;
	$dbg=&$dbg;
	$data['students']=$students=classSummaries($db,$dbg,$crid,$male=2,$order,$fields,$filter,$limits,$active);				
	$data['sem']=$sem=isset($_GET['sem'])?$_GET['sem']:0;
	$data['num_students']=count($data['students']);
	$data['courses']=matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter=NULL,$sem);	
	// debug($q,"BonuxFxn: matrix subjects ");		
	$data['num_courses']=count($data['courses']);
	$tcid=$_SESSION['user']['ucid'];
	$grades=array();
	foreach($students AS $row){ $grades[]=matrixGrades($db,$dbg,$row['scid'],$filter=NULL,$sem); }	
	$data['grades'] = $grades;
	
	/* attendance attd */
	$data['months'] = $months = attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] = $month_names = fetchRows($db,"{$dbo}.`05_months_quarters`",'*','`index`'," WHERE quarter = $qtr ");	
	$data['num_months'] = $num_months = count($data['month_names']);
	foreach($students AS $row){ $attd[] = attendance($db,$dbg,$sy,$row['scid']); }		
	
	$attd=isset($attd)? $attd:NULL;
	$data['attd'] = $attd;	
	
	
	if(isset($_GET['sem'])){
		$sem=$_GET['sem'];
		$data['period']=$period="Semester $sem";		
	} else {
		$data['period']=$period="Q{$qtr}";				
	}
	$data['page'] = "Consolidated Grading Sheet - SY".$sy." $period";	
	
	$sch=VCFOLDER;
	$one="matrix_{$sch}";$two="matrix/gradesMatrix";
	$vfile=cview($one,$two,$sch=VCFOLDER);	
	if(isset($_GET['sem'])){
		$one="matrixSem";$two="matrix/semgradesMatrix";
		$vfile=cview($one,$two,$sch=VCFOLDER);		
	}
	
	if(isset($_GET['vfile'])){ pr($vfile); }
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
	$db=& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;	
	
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
	
	$order="c.is_male DESC,c.name";
	$fields="c.attschema_id,";
	$filter=null;
	$limits=null;
	$active=false;
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



/* param2[0] course_id,param2[1] = qtr (default current setting)  */
public function view($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/classlist.php");
	require_once(SITE."functions/bonuses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	
	$data['home']=$_SESSION['home'];
	$data['user']=$user=$_SESSION['user'];
	$crid=$data['crid']	=$params[0];	
	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['ssy']=&$ssy;
	$data['sqtr']=&$sqtr;
	$sy=isset($params[1])?$params[1]:DBYR;
	$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];	
	$data['sy']=$sy;$data['qtr']=$qtr;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['db']=&$db;$data['dbg']=&$dbg;
	
	$data['srid']	= $srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD,RTEAC);
	$data['admin'] = $admin = in_array($srid,$adroles)? true:false;
	
	$cr=$data['classroom']=getClassroomDetails($db,$crid,$dbg);	
	$data['dept']=$dept=$cr['department_id'];
	$deptrow=getDepartmentArray($dept);
	$data['deptcode']=$deptcode=strtolower($deptrow['dept_code']);
	
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	if($srid==RTEAC and !$adviser){ if($_SESSION['user']['privilege_id']>0){ flashRedirect($home); } }
	
	
	$data['is_locked']=$is_locked=$cr['is_finalized_q'.$qtr];
	$data['trait']=getClassroomConductCourse($db,$dbg,$crid,CTYPETRAIT);
	$data['conduct']=getClassroomConductCourse($db,$dbg,$crid,CTYPECONDUCT);

	$order=$_SESSION['settings']['classlist_order'];
	$order= (isset($_GET['sort']))? $_GET['sort']:$order;	
	$fields = "sum.id AS sumid,c.parent_id AS pcid,";
	$filter=null;$limits=null;$active=false;
	$dbg=&$dbg;
	$data['students']=$students=classSummaries($db,$dbg,$crid,$male=2,$order,$fields,$filter,$limits,$active);				
	$data['sem']=$sem=isset($_GET['sem'])?$_GET['sem']:0;
	$data['num_students']=count($data['students']);
	$data['courses']=matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter=NULL,$sem);	
	// debug($q,"BonuxFxn: matrix subjects ");		
	$data['num_courses']=count($data['courses']);
	$tcid=$_SESSION['user']['ucid'];
	$grades=array();
	foreach($students AS $row){ $grades[]=matrixGrades($db,$dbg,$row['scid'],$filter=NULL,$sem); }	
	$data['grades'] = $grades;
	
	/* attendance attd */
	$data['months'] = $months = attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] = $month_names = fetchRows($db,"{$dbo}.`05_months_quarters`",'*','`index`'," WHERE quarter = $qtr ");	
	$data['num_months'] = $num_months = count($data['month_names']);
	foreach($students AS $row){ $attd[] = attendance($db,$dbg,$sy,$row['scid']); }		
	
	$attd=isset($attd)? $attd:NULL;
	$data['attd'] = $attd;	
	
	
	if(isset($_GET['sem'])){
		$sem=$_GET['sem'];
		$data['period']=$period="Semester $sem";		
	} else {
		$data['period']=$period="Q{$qtr}";				
	}
	$data['page'] = "Consolidated Grading Sheet - SY".$sy." $period";	
	
	$sch=VCFOLDER;
	$one="matrixView_{$sch}";$two="matrix/viewMatrix";
	$vfile=cview($one,$two,$sch=VCFOLDER);	
	if(isset($_GET['sem'])){
		$one="matrixSemView";$two="matrix/semgradesMatrixView";
		$vfile=cview($one,$two,$sch=VCFOLDER);		
	}
	if(isset($_GET['vfile'])){ pr($vfile); }
	$this->view->render($data,$vfile);

} 	/* fxn */






} 	/* MatrixController */
