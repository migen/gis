<?php

class GtoolsController extends Controller{	

	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$acl = array(array(RMIS,0),array(RREG,0),array(RTEAC,0),array(RACAD,0));
	$this->permit($acl);				
	
}	/* fxn */



public function index(){
	echo "<h3>Utility index</h3>";

}


/* for bonuses individual syncGrades like mis/syncGrades */ 
public function msg($params=NULL){		
	$dbo=PDBO;	
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');	
	require_once(SITE."functions/classrooms.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/utils.php");
	$db =& $this->model->db;$dbg=PDBG;
		
/* from ccr */ 
	$data['home']=$home=$_SESSION['home'];
	// $data['crid']	= $crid		= isset($params[0])? $params[0]:false;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;	
	$data['qtr']=$qtr=isset($params[2])? $params[2]:4;	
	
	$data['ucid']	= $ucid		= $scid;
	$data['srid']	= $srid		= $_SESSION['srid'];
	
	$_SESSION['url']	= "gtools/msg/$scid";
			
	$allowed = array(RMIS,RREG,RTEAC); 
	$srid 	 = $_SESSION['user']['role_id']; 	
	if(!in_array($srid,$allowed)){ flashRedirect($home); } 


/* ------------- for batch edits ------------- */
	if(isset($_POST['batch'])){
		$rows = $_POST['rows'];
		foreach($rows AS $gid){ deleteGrade($db,$dbg,$gid); }
		Session::set('message','Delete Grades Successfully!');
		$url = isset($_SESSION['url'])? $_SESSION['url']:"matrix/grades/$crid";
		redirect($url);		
		exit;
	}

	if(isset($_POST['move'])){
		$scid = $_POST['scid'];   /* crid from */
		$crf  = $_POST['crf'];   /* crid from */
		$crt  = $_POST['crt'];	/* crid to   */
		
		$crstudent = studentInClassroom($db,$dbg,$crf,$scid);
		if(empty($crstudent)){		
			$_SESSION['message'] = "No student found!";		
		} else {
			/* 1 - subjects */		
			$rows = msgAllsubjects($db,$crf,$dbg,$sem=1);
					
			/* 2 delete all crt courses */
			dsgs($db,$dbg,$crt,$scid);
			
			/* 3 - msg */
			foreach($rows AS $row){ msg($db,$dbg,$scid,$crf,$crt,$row['subject_id']); }
			
			/* 4 - resection scid from crf to crt */
			sxn($db,$dbg,$scid,$crf,$crt);
			$_SESSION['message'] = "Transferred grades done!";
		}
			
		$url = "gtools/msg/$scid";		
		$_SESSION['url']=$url;
		flashRedirect($url,'Student Records Transferred.');		
		exit;
	}
	
/* ------------- data ------------- */	

	$q = "SELECT c.id AS scid,c.name AS student,c.code AS student_code,cr.name AS classroom,
			summ.crid AS crid,cr.level_id
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE c.id = '".$scid."' LIMIT 1; ";
	$sth = $db->querysoc($q);	
	$data['student'] 		= $student	= $sth->fetch();	
	$data['crid']=$crid=$student['crid'];	
	$data['courses']=$courses=cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter=null);	
	$data['num_courses']=$num_courses=count($data['courses']);


	$q = "SELECT crs.id AS crs,crs.subject_id,crs.id AS course_id,crs.name AS course,crs.is_active,crs.crstype_id AS ctype_id,crs.label,
			crs.crid AS crid,g.id AS gid,g.q5 AS fg,g.*
		FROM {$dbg}.50_grades AS g
			LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		WHERE g.scid = '".$scid."' 
		ORDER BY crs.crid,crs.position,crs.id; ";
		// ORDER BY crs.crid,crs.position
	debug($q);
	$sth = $this->model->db->querysoc($q);		
	$data['grades']=$grades=$sth->fetchAll();		
	$data['count']=$count=count($data['grades']); 
	
	
	$ar=buildArray($courses,'crs');	// crid courses
	$br=buildArray($grades,'crs');	// scid courses
	$ix = array_diff($ar,$br);	// add to grades, 	
	// $jx = array_diff($br,$ar);		


	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_grades (`scid`,`course_id`) VALUES  ";
		foreach($ix AS $crs){ $q .= " ($scid,$crs),"; }
		$q = rtrim($q,",");
		$q .= ";";	
		$db->query($q);
		$str_courses=implode($ix,',');
		flashRedirect("gtools/msg/$scid","Sync-added grades - $str_courses ");
	}


	// pr('crid courses -> stud grades');
	// pr($ix);
	// exit;
	
	$q="GtoolsController msg - $q";
	$data['q']=$q;
	
	if($_SESSION['srid']==RTEAC){ if(!in_array($student['crid'],$_SESSION['teacher']['advisory_ids'])){ flashRedirect('teachers'); } } 
	$data['home'] = $home;	
	
	$level_id = $student['level_id'];
	$classrooms = isset($_GET['all'])? fetchRows($db,"{$dbg}.05_classrooms","id,name"):getClassroomsByLevel($db,$level_id,$dbg);
	$data['classrooms'] = $classrooms;
	$vfile="gtools/msg";vfile($vfile);
	$this->view->render($data,$vfile);

}	 /* fxn */



public function syncGradesByStudent($params){	
$dbo=PDBO;	
require_once(SITE."functions/details.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/syncGrades.php");
$db =& $this->model->db;

$data['ucid'] 	= $ucid = $params[0];
$data['ssy']	= $ssy 	= DBYR;
$data['sy']		= $sy	= $ssy; 
$today = $_SESSION['today'];

$dbo=PDBO;$dbg=PDBG;
/* ----------------------------------------------------------------------------------- */
$data['students'] 		= $students		= getclassyearByStudent($db,$dbg,$sy,$ucid);		/* GModel */
$data['crid']			= $crid			= $students[0]['crid'];

$data['cr'] = $cr = getClassroomDetails($db,$crid,$dbg);
$crstype = isset($params[1])? $params[1] : 1;
$data['courses'] = $courses = cridCourses($db,$dbg,$crid,$acad=$crstype,$agg=1);

$ar = buildArray($courses,'course_id');


/* 1 - sync Grades  */
foreach($students AS $row){ 
	$scid = $row['scid'];
	$q = " SELECT course_id FROM {$dbg}.50_grades WHERE `crstype_id` = '".$crstype."' AND `scid` = '$scid'; ";
	$sth = $this->model->db->querysoc($q);
	$courses = $sth->fetchAll();
	$br = buildArray($courses,'course_id');	
	$ix = array_diff($ar,$br);	
	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_grades (`course_id`,`scid`,`crstype_id`) VALUES  ";
		foreach($ix AS $crs){
			$q .= " ('$crs','$scid','".$crstype."'),";
		}
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);
	}
}	/* foreach-students */


/*  2 - sync summaries */
/*  no need to insert into dbgis.05_summaries since classlist is derived from dbgis.05_summaries  */
 

/*  3 - sync attendance */
$q = " INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES  ";
foreach($students AS $row){ 
	$scid = $row['scid'];	
	$q .= " ('$scid'),";
}	/* foreach-sync attendance */
$q = rtrim($q,",");
$q .= ";";
$db->query($q);

/*  4 - lock_init */
$ctype =  'grades';
$q = " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '1',`init_grades_date` = '$today' 
		WHERE `id` = '$crid' LIMIT 1;  ";
$db->query($q);

/*  5 - redirect */
$url = isset($_SESSION['url'])? $_SESSION['url']: "classrooms/level/".$cr['level_id'].DS.$sy;
$_SESSION['message'] = "Grades Synced";
redirect($url);

}	/* fxn */






}	/* GtoolsController */