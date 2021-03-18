<?php

Class EtcscoresController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */



/* IMPT: for 3T */
public function raw($params){	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/scores.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/transmutation.php");	
	require_once(SITE."functions/classifications.php");
	$db	=&	$this->model->db;

	$data['course_id']	= $course_id  	= $params[0];
	$data['sy']			= $sy  			= $params[1];
	$data['qtr']		= $qtr  		= $params[2];

$dbg = VCPREFIX.$sy.US.DBG;
	
	$data['home']	=	$home = $_SESSION['home']; 				
	$_SESSION['url'] = "teachers/scores/$course_id/$sy/$qtr";
	
if($home=='teachers'){ if((!in_array($course_id,$_SESSION['teacher']['course_ids']))) { flashRedirect('teachers'); } }	
	
	/* list students */
	$course = $data['course'] 	= getCourseDetails($db,$course_id,$dbg);
	$_SESSION['course'] 		= $course;
		
	/* from model scores */
	$data['curr_qtr'] 		 = $_SESSION['qtr'];
	$data['is_locked'] 		 = $course['is_finalized_q'.$qtr];
	$data['course_id']		 = $course_id;
	$data['qtr'] 		 	 = $qtr;
	$crsClass	= classifyCourse($course);
	$data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
	
	$crid			  = $course['crid'];	
	if($data['is_locked']){ $order = " g.`q$qtr` DESC ";		
	} else { $order = "c.is_male DESC,c.name ASC"; }	
	$data['students'] 	= classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order );		
	
	$data['kpup']	  = $kpup	= $course['is_kpup']; 
	$data['tier']	  = $tier	= $_SESSION['settings']['tier_adapter']; 
	$data['with_score_ranks'] 	= $_SESSION['settings']['with_score_ranks'];
	
	$data['activities'] = getActivities($db,$dbg,$course_id,$qtr);	
	foreach($data['students'] AS $student){ $data['scores'][] = getScores($db,$dbg,$course_id,$student['scid'],$qtr);	}		
		
	$data['num_students'] 	= count($data['students']);
	$data['num_scores'] 	= isset($data['scores'])? count($data['scores']) : 0;
	$data['num_activities'] = count($data['activities']);

/* ------------ finalize button control ----------------------------------------------------- */
	/* for components */
	$level_id 	= $course['level_id'];
	$subject_id = $course['subject_id'];	
	$data['editable'] 			= (!$data['is_locked'] && $home=='teachers' && !$data['course']['is_aggregate']);	
	$data['locked_with_ranks'] 	= ($data['is_locked'] && $data['with_score_ranks']);
	
/* ----------------------------------------------------------------------------------------- */

if(isset($_POST['export'])){
	$excel = array();
	$excel[0][] 		= "SCID";
	$excel[0][] 		= "Student";
	$k = 0;
	foreach($data['activities'] AS $act){
		$excel[0][] = $act['activity'].'-'.$act['max_score'];
		$k++;
	}	
	$i=1;		
	foreach($data['scores'] AS $rows){
		$excel[$i] = array();		
		$h = $i-1;
		$excel[$i]['scid'] 		= $data['students'][$h]['scid'];
		$excel[$i]['student'] 	= $data['students'][$h]['student'];
		foreach($rows AS $row){
			$excel[$i][] = $row['score'];
		}		
		$i++;
	}

	$this->export($excel,'raw');	
	unset($_POST['export']); 
	exit;		
}
						
	$this->view->render($data,'teachers/raw3T');
				
}	/* fxn */


/* summaryScores,IMPT: 3T */
public function sumscores($params){	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/scores.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/transmutation.php");
	$db	=&	$this->model->db;

	$data['course_id']	= $course_id = 	$params[0];	
	$data['ssy']	= $ssy  = $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;	
	$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	

	$dbg = VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home'] =	$home = $_SESSION['home']; 			
	
/* -------------------------------------------------------------------------------------------- */		
			
	/* list students */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);

	/* from model scores */
	$data['current_qtr'] 	 = $_SESSION['qtr'];
	$data['is_locked'] 		 = $course['is_finalized_q'.$qtr];
	$data['course_id']		 = $course_id;
	$data['qtr'] 		 	 = $qtr;
	
	$crid = $course['crid'];	

	$order="c.is_male DESC,c.name";
	$data['students'] 	= classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order);		
	
	$data['is_k12']		  	= $is_k12		= $course['is_kpup']; 
	$data['kpup']	  = $kpup	= $course['is_kpup']; 
	$data['tier']	  = $tier	= $_SESSION['settings']['tier_adapter']; 
	
	$data['activities'] = getActivities($db,$dbg,$course_id,$qtr);	
	foreach($data['students'] AS $student){ $data['scores'][] = getScores($db,$dbg,$course_id,$student['scid'],$qtr);	}	
	
	$data['num_students'] 	= count($data['students']);
	$data['num_activities'] = count($data['activities']);		

	$data['editable'] 			= (!$data['is_locked'] && $home=='teachers');	
	$data['selects'] 		= selectsCourseCriteria($db,$course_id);						
	
	$this->view->render($data,'teachers/sumscores3T');
				
}	/* fxn */








}	/* EtcscoresController */
