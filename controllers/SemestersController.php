<?php

Class SemestersController extends Controller{	

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







/* like grades but finalizes fg and dgf,no need for course to do so */
public function conducts($params){	
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/conducts.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;

	$data['home']	= $home	= $_SESSION['home'];
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['course_id']	= $course_id  	= $params[0];
	$data['sy'] 		= $sy 			= isset($params[1])? $params[1] : $ssy;
	$data['qtr'] 		= $qtr 			= isset($params[2])? $params[2] : $sqtr;
	$data['qqtr'] 		= $qqtr 		= 'q'.$qtr;
	$data['intfqtr']	= $intfqtr 		= ($qtr<3)? 5:6;
	$_SESSION['url']	= "conducts/records/$course_id/$sy/$qtr";	
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$data['home']	=	$home 			= $_SESSION['home']; 				
	$data['derivsem']	= $derivsem		= ($qtr>2)? 2:1;
	$_SESSION['url'] = "semesters/conducts/$course_id/$sy/$qtr/$derivsem";	
	
	/* ------------------ process ---------------  */
	$data['course'] = $course 	= getCourseDetails($db,$course_id,$dbg);
	$data['flrgr'] 	= $flrgr 	= getCourseFloorGrade($course,$_SESSION['settings']);		
	$data['crid']	= $crid		= $course['crid'];
	$_SESSION['course'] = $course;		
	
		
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
	
	$crsClass		 = classifyCourse($course);
	$data['ratings'] = $ratings	= getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
		
	$data['is_locked']  = $course['is_finalized_q'.$qtr];
	$data['is_k12']		= $is_k12		= $course['is_k12'];
	$data['with_dg']	= $with_dg		= $course['with_conduct_dg'];
	
	$order=$_SESSION['settings']['classlist_order'];	
	$order=isset($_GET['order'])? $_GET['order']:$order;

	$data['conducts'] 	= getClassroomConducts($db,$dbg,$crid,$course_id,$sy,$qtr,$order);		
	$data['num_conducts'] = count($data['conducts']);		
	
$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order,$flds=NULL,$fltrs=NULL,$lmt=NULL,$active=1);
$data['num_students'] = count($data['students']);	

	/* update or ranking */
	if(isset($_POST['submit'])){
		$rows 		= $_POST['data']['summary'];		
		$qodd = ($qtr%2)? true:false;
		$idiv = ($qodd)? 1:2;
		$sem1 	 = ($qtr<3)? true:false;

		/* update summaries for each classroom student */
		$q = "";		
		foreach($rows AS $row){
			if($row['q'.$qtr] < $flrgr) {  $row['q'.$qtr] = $flrgr; }
			
			/* update grades final or fg  */
			if($qodd && $sem1){
				$total = $row['q1'];
			} elseif($qodd && !$sem1){
				$total = $row['q3'];
			} elseif(!$qodd && $sem1){
				$total = $row['q1']+$row['q2'];
			} else {
				$total = $row['q3']+$row['q4'];
			}

			$fg  = $total/$idiv;
			$dg  = rating($row['q'.$qtr],$ratings);
			$dgf = rating($fg,$ratings);
			
			$q .= " 
				UPDATE {$dbg}.50_grades SET 
						`q$qtr` = '".$row['q'.$qtr]."',`q$intfqtr` 	 = '".$fg."' ";						
			$q .= " ,`dg$qtr` 	= '".$dg."',`dg$intfqtr`	= '".$dgf."'  "; 
			$q .= " WHERE `id` = '".$row['gid']."' LIMIT 1; ";
				
			$q .= " UPDATE {$dbg}.05_summaries SET 
					`conduct_q$qtr` = '".$row['q'.$qtr]."',`conduct_q$intfqtr` = '".$fg."'  ";
			$q .= " ,`conduct_dg$qtr` 	= '".$dg."',`conduct_dg$intfqtr`	= '".$dgf."'  "; 														
			$q .= " WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
			

			
		}	/* foreach */
			
		$this->model->db->query($q);				
		$url = "semesters/conducts/$course_id/$sy/$qtr/$derivsem";		
		redirect($url);				
	}	/* refresh */
	
	
	$this->view->render($data,'semesters/conducts');


}	/* fxn */






}	/* SemestersController */
