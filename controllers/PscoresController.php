<?php

Class PscoresController extends Controller{	/* GISController from bootstrap */

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	parent::beforeFilter();		
	
}

public function index(){ pr('pscores index'); }


/* IMPT: for 3T */
public function scores($params){	
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/vegas_tables.js');	

$sq="";	/* session query */ 
	if($_SESSION['settings']['custom_equiv']==1){
		require_once(SITE."views/customs/".VCFOLDER."/equivs_".VCFOLDER.".php");	
	} else {
		require_once(SITE."functions/equivs.php");	
	}

	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/sessionize.php");	
	require_once(SITE."functions/sessionize_teacher.php");	
	require_once(SITE."functions/pscoresFxn.php");
	require_once(SITE."functions/transmutation.php");
	require_once(SITE."functions/counts.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;

	$data['home']	=	$home = $_SESSION['home']; 			

	$data['course_id']	= $course_id  	= $params[0];
	$data['sy']			= $sy  			= isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']		= $qtr  		= isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['user']		= $user			= $_SESSION['user'];
	$data['teacher'] 	= $teacher		= ($user['role_id']==RTEAC)? true:false;
	$data['srid']		= $srid			= $_SESSION['srid'];
	$data['admin']	= (($srid==RMIS) || ($srid==RREG))? true:false;
	$dbg = VCPREFIX.$sy.US.DBG;	
	
	$_SESSION['url']    = "teachers/scores/$course_id/$sy/$qtr";
	$data['course']     = $course = getCourseDetails($db,$course_id,$dbg);
	$data['with_dg'] = isset($_GET['dg'])? $_GET['dg']:$course['is_k12'];
	$_SESSION['course'] = $course;
	$subdepartment_id=$course['subdepartment_id'];
	
	$data['sem'] = $sem = $course['semester'];
	$data['qf']  = $qf  = ($sem==2)? 'q6':'q5';
	$data['dgf'] = $dgf = ($sem==2)? 'dg6':'dg5';
	
	$data['is_transmuted']	= $is_transmuted = ($course['is_transmuted']==1)? true:false;
	
	$data['crid']	= $crid = $course['crid'];
	
if($srid==RTEAC){ if((!in_array($course_id,$_SESSION['teacher']['course_ids']))) { flashRedirect('teachers'); } }	
	
			
	/* from model scores */
	$data['curr_qtr'] 		 = $_SESSION['qtr'];
	$data['is_locked'] 		 = $course['is_finalized_q'.$qtr];
	$data['course_id']		 = $course_id;
	$data['qtr'] 		 	 = $qtr;
	
	$crsClass	= classifyCourse($course);
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$data['ratings'] = getRatings($db,$ctype,$dept_id);		
	$data['equivs'] = $equivs = getEquivs($db,$ctype,$dept_id);		
	
	$crid = $course['crid'];	
	$data['with_score_ranks'] = $_SESSION['settings']['with_score_ranks'];
	$data['dr']=getDepartmentArray($course['department_id']);
	
	if($data['is_locked'] && $data['with_score_ranks']){ $order = " g.`q$qtr` DESC ";		
	} else { $order = "c.grp,c.is_male DESC,c.name ASC"; }

$order=(isset($_GET['sort']))? $_GET['sort']:$order;
$data['students']=classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order);		

$data['num_scores']	= count($data['students']);
$data['num_students'] = countStudents($db,$dbg,$sy,$crid);
			
$data['kpup']	  = $kpup	= $course['is_kpup']; 
$data['tier']	  = $tier	= $_SESSION['settings']['tier_adapter']; 
	

$data['activities'] = getPactivities($db,$dbg,$course_id,$qtr,$sy);	
foreach($data['students'] AS $student){ $data['scores'][] = getPscores($db,$dbg,$course_id,$student['scid'],$qtr,$sy);	}
$sq.=$_SESSION['q'];

		
	$data['num_activities'] = count($data['activities']);

/* ------------ finalize button control ----------------------------------------------------- */
	/* for components */
	$level_id 	= $course['level_id'];
	$subject_id = $course['subject_id'];

	/* course components */
	$q = "
		SELECT count(comp.id) AS ct
		FROM {$dbg}.05_components AS comp
		WHERE comp.level_id = '$level_id' AND comp.subject_id = '$subject_id'; 
	";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$data['num_crs_components'] 		= $row['ct'];

	/* activities components */
	$q = "
		SELECT act.id,act.component_id,act.name
		FROM {$dbg}.50_activities AS act
		INNER JOIN {$dbg}.05_courses AS crs ON act.course_id = crs.id
		WHERE act.course_id = '$course_id' AND act.quarter = '$qtr' 
		GROUP BY act.component_id;
	";
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();		
	$data['num_acts_components'] = count($rows);

	$data['editable'] 			= (!$data['is_locked']);
	$data['locked_with_ranks'] 	= (!$data['is_locked'] && $data['with_score_ranks']);
	$data['selects'] 		= selectsCourseCriteria($db,$course_id);	
	
	
	$vpath = SITE.'views/customs/'.VCFOLDER.'/scores3T.php';		
	if(is_readable($vpath)){
		$vfile="/customs/".VCFOLDER."/scores3T";	
	} else {
		$vfile="teachers/scores3T";		
	}
		
	debug($sq);
	$this->view->render($data,$vfile);			
	
}	/* fxn */




} 	/* TeachersController */
