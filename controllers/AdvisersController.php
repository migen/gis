<?php

/* crscfg, */
Class AdvisersController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}

public function index(){
	echo "advisers index homepage ";

}	/* fxn */


public function crscfg($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;$dbg=PDBG;
$data['home']=$_SESSION['home'];
$data['crid']=$crid = $params[0];
$data['ssy']=$ssy=$_SESSION['sy']; 

if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  flashRedirect('teachers'); } }
$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
$crname=$data['classroom']['name'];

if(isset($_POST['submit'])){
	$rows = $_POST['crs'];
	$q = "";
	foreach($rows AS $row){
		$q .= "UPDATE {$dbg}.05_courses SET `name` = '".$crname."-".$row['label']."',`label` = '".$row['label']."',
			`position` = '".$row['position']."',`indent` = '".$row['indent']."' WHERE `id`='".$row['course_id']."' LIMIT 1; ";
	}
	// pr($q);exit;
	$db->query($q);
	$url = "advisers/crscfg/$crid";
	flashRedirect($url,"Saved.");
	exit;

}	/* post */


/* process */
$q = "SELECT crs.*,crs.id AS course_id,sub.position AS subject_position		
	FROM {$dbg}.05_courses AS crs LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
	WHERE crs.`crid` = '$crid' AND crs.`is_active` = '1' ORDER BY sub.position,crs.position; ";
if(isset($_GET['debug'])){ pr("cridCourses"); pr($q); }
$sth=$db->querysoc($q);
$data['courses']=$sth->fetchAll();
$data['count']=count($data['courses']);
$this->view->render($data,'advisers/crscfg');

}	/* fxn */


public function sircard($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/frcards.php");
	$db =& $this->model->db;

	$data['home'] = $home = $_SESSION['home'];
	if(is_null($params)) redirect($home);
	$data['ssy']	= $ssy	= $_SESSION['sy']; 
	$data['scid'] 	= $scid = $params[0];
	$data['sy']		= $sy	= isset($params[1])? $params[1]:$ssy; 
	$data['qtr']	= $qtr	= isset($params[2])? $params[2]:$_SESSION['qtr']; 
	$data['sem']	= $sem	= isset($params[3])? $params[3]:'0'; 	
	$current=($sy==DBYR)? true:false; 	
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	
	$data['user']=$user=$_SESSION['user'];
	$title_id=$user['title_id'];	
	$role_id=$user['role_id'];	
	$data['admin']=$admin=(($role_id == RREG) || ($role_id == RMIS))? true:false;
	if(!$admin) { flashRedirect('index/unauth'); } 

$fields = ($_SESSION['settings']['with_chinese']==1)? 'c.chinese_name,':NULL;
$students[] = student($db,$dbg,$sy,$scid,$fields=NULL);
	$data['crid']			= $crid	= $students[0]['crid'];
		
	$data['num_students']	= $num_students = '1';
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
	$data['traits']			= $traits 		= ($classroom['conduct_ctype_id']==CTYPETRAIT)? 1:0;

	
	/* 1) grades,2) attendance,3) conducts,4) if applicable-psmapehs */
	
	for($i=0;$i<$num_students;$i++){		
		$students[$i]['summary'] 		= summary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
		$students[$i]['grades'] 		= grades($db,$dbg,$sy,$crid,$students[$i]['scid'],$sem); 	
		$students[$i]['attendance'] 	= attendance($db,$dbg,$sy,$students[$i]['scid']); 		
	}	/* for */ 
	
	if($_SESSION['settings']['with_chinese']==1){
		for($i=0;$i<$num_students;$i++){		
			$students[$i]['sumo']=sumo($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
		}	/* for */ 	
	}

	/* pr($classroom); */
	if($classroom['conduct_ctype_id']==CTYPETRAIT){	
		for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = traits($db,$dbg,$sy,$students[$i]['scid']); }		
	} else {	
		for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = conducts($db,$dbg,$sy,$students[$i]['scid']); }				
	}
	
	$data['students'] = $students;
	

/* ----------------- process --------------------------------------------------------------------------- */			
			
	$data['months'] 	 	= attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] 	= $this->model->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');		
	$data['num_months']		= count($data['month_names']);

	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	/* arm-Model */
	$data['courses_locked'] = $courses_locked;

	$data['printable']	= true;
	if($ssy == $sy){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;

	$conduct_ctype = $classroom['conduct_ctype_id'];
$data['legendcrs'] 	= legends($db,$dbg,$ctype=1,$classroom['department_id']);
$data['legendtr'] 	= legends($db,$dbg,$ctype=$conduct_ctype,$classroom['department_id']);

	$data['numacad'] = count($students[0]['grades']);
	$coll = ($sem==0)? '':'_sem';

	if($sem>0){
		$data['sq1'] = ($sem==1)? 'q1':'q3';
		$data['sq2'] = ($sem==1)? 'q2':'q4';
		$data['dsq1'] = ($sem==1)? '1':'3';
		$data['dsq2'] = ($sem==1)? '2':'4';		
	}
	
	
	$vfile = 'customs/'.VCFOLDER.DS.'rcard'.$coll;
	$this->view->render($data,$vfile);
	

}	/* fxn */



public function printAttd($params){
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
	$current	= $data['current']	= ($sy==DBYR)? true:false;	
	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	/* is_locked = advisers_quarters.attendance_q# */
	$cr = $data['classroom']  = getClassroomDetails($db,$crid,$dbg);	
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
	$data['attendance_months'] 	= getAttendanceMonths($db,$cr['level_id'],$sy,$dbg);	 	 
	foreach($data['students'] AS $row){ $data['attendance'][] = getStudentAttendance($db,$dbg,$sy,$row['scid']); }
	$data['today']		= $_SESSION['today'];
	$data['crid']		= $crid;
	
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
	$_SESSION['crid'] = "$crid";	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms");
			
	$this->view->render($data,'advisers/printAttd');

} 	/* fxn */


public function averager(){
	$dbo=PDBO;
	require_once(SITE."functions/averager.php");
	$db=&$this->model->db;$dbg=PDBG;
	$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	averager($db,$dbg,$qtr);	
	exit;	
}	/* fxn */


public function scid($params){
	$data['scid']=$scid=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;
	
	$q="SELECT c.*,summ.crid,g.*,crs.name AS subject
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.50_grades AS g ON g.scid=c.id
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		WHERE c.id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$this->view->render($data,"advisers/scidAdviser");




}	/* fxn */






} 	/* AdvisersController */
