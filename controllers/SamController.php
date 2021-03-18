<?php
/* scores activities manager */
Class SamController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "<h3>Scores Activities Manager</h3>";

}	/* fxn */



public function activities($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");	
	require_once(SITE."functions/scores.php");	
	require_once(SITE."functions/scores_activities.php");	
	$db =& $this->model->db;	
	$course_id = isset($params[0])? $params[0] : null;
	$ssy = $_SESSION['sy'];
	$sy = isset($params[1])? $params[1] : $ssy;
	$qtr = isset($params[2])? $params[2] : $_SESSION['qtr'];
	$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
		
	/* list students */
	if($course_id){			
		$data['course'] = getCourseDetails($db,$course_id,$dbg);
		$_SESSION['course'] = $data['course'];
		if($_SESSION['srid']==RTEAC){
			if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){flashRedirect($_SESSION['home'],'Others.');} 		
		} 
		$data = activities($db,$dbg,$course_id,$qtr);					
		
		$data['course_id'] = $course_id;$data['ssy'] = $ssy;$data['sy'] = $sy;$data['qtr'] = $qtr;		
		$this->view->render($data,'sam/activities');
	} else {		
		flashRedirect($_SESSION['home']);
	}		

}	/* fxn */

public function purgeCourseScores($params){
$dbo=PDBO;
$crs=$params[0];
$sy=isset($params[1])? $params[1]:DBYR;
$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->model->db;
$dbg=PDBG;
$q="DELETE FROM {$dbg}.50_activities WHERE `course_id`='$crs' AND quarter='$qtr'; ";
$q.="DELETE FROM {$dbg}.50_scores WHERE `course_id`='$crs' AND quarter='$qtr'; ";
if(isset($_GET['exec'])){
	$db->query($q); 
	flashRedirect("sam/purgeCourseScores/$crs/$sy/$qtr","Course Scores for Q{$qtr} purged.");
}
$data['q']=$q;
$data['q'].="<h3>&exec</h3>";
$data['message']="To be executed by MIS only. ";
$this->view->render($data,'sam/purgeCourseScores');

}	/* fxn */








}	/* SamController */
