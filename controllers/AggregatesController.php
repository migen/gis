<?php

Class AggregatesController extends Controller{	

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



public function tally($params){
	$dbo=PDBO;
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/sessionize.php");	
	require_once(SITE."functions/sessionize_teacher.php");	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/aggregates.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;
	
	
/* ------------------- params --------------------------------------------------------------- */
	$data['home']=$home=$_SESSION['home'];
	$data['crid']=$crid=$params[0];
	$data['course_id']=$course_id=$params[1];
	$data['supsubject_id']=$supsubject_id=isset($params[2])? $params[2]:0;
	$data['sy']=$sy=isset($params[3])? $params[3] : $_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[4])? $params[4] : $_SESSION['qtr'];

	$data['srid']=$srid=$_SESSION['srid'];
	$adroles=array(RMIS,RREG,RACAD);
	$data['admin']=in_array($srid,$adroles)? true:false;	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	$data['course'] = $course	= getCourseDetails($db,$course_id,$dbg);
	$decicard = $course['decimal'];		/* subject.decimal */
	$data['decicard']	= $decicard = isset($_GET['deci'])? $_GET['deci']:$decicard;
	
/* ------------------- check if num_aggregate grades == $num_students in classlist ------------------------------------- */

	$q = " SELECT c.id AS scid FROM {$dbo}.`00_contacts` AS c INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE summ.`crid` = '$crid' AND c.`is_active` = 1; ";
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');
	
	$q=" SELECT `scid` FROM {$dbg}.50_grades WHERE `course_id` = '$course_id'; ";
	$sth=$db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'scid');
	$ix = array_diff($ar,$br);
	if(!empty($ix)){ Session::set('message','Number of classlist students and grades do NOT match.');  $data['ix'] = $ix;	 }
		
	/* need 1) course details and 2) students for crid for post-2) updating final grade */
	$order=$_SESSION['settings']['classlist_order'];
	$fields="c.is_male,";
	$students  = classGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order,$fields);	
	$data['students']=&$students;	
	
	$is_locked=$data['is_locked']=$course['is_finalized_q'.$qtr];
	$crsClass=classifyCourse($course);
	$with_dg=$_SESSION['settings']['with_dg'];
	$with_rating=&$with_dg;
	$data['with_dg']=&$with_dg;
	$data['with_rating']=&$with_dg;
	if($with_dg){ $data['ratings']=getRatings($db,$crsClass['type_id'],$crsClass['dept_id']); }
	
	
	/* security check is in the submissions page,so here no need to check in_array */
	if(isset($_POST['submit'])){
		$qqtr 	= 'q'.$qtr;
		$dgqtr 	= 'dg'.$qtr;
		$rows	= (isset($_POST['data']['aggregate']))? $_POST['data']['aggregate']:array();
		$q = "";
		/* 1-update quater */
		foreach($rows AS $row){
			if(!$with_dg) { $row[$dgqtr] = 'F'; }				
				$q .= " UPDATE {$dbg}.50_grades SET `$qqtr` = '".$row[$qqtr]."',`$dgqtr` = '".$row[$dgqtr]."' 
						WHERE `id` = '".$row['gid']."' LIMIT 1; ";
					
		}	/* foreach */					
		
		if($course['crstype_id']==CTYPECONDUCT){
			foreach($rows AS $row){
				if(!$with_dg) { $row[$dgqtr] = 'F'; }				
					$q .= " UPDATE {$dbg}.05_summaries SET `conduct_$qqtr` = '".$row[$qqtr]."',
						`conduct_$dgqtr` = '".$row[$dgqtr]."' WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
			}	/* foreach */					
				
		}	
		if(!empty($q)){ $db->querysoc($q); }
		if($qtr>3){ require_once(SITE."functions/averager.php");averageCourse($db,$course); }
		
		lockCourse($db,$course_id,$qtr,$dbg);
		sessionizeTeacher($db,$dbg);			
		
		/* redirect to course to get final grades and dg5 */
		$url=$home;
		if($qtr>3){
			$url = "averages/course/$course_id/$sy/$qtr";			
		}
		flashRedirect($url,'Tally Aggregates done.');		
	}	/* post-submit */


/* -------------------- process ---------------------------------------------------------------------- */		
			
		foreach($students AS $student){
			$grades[] = getStudentAggregates($db,$dbg,$student['scid'],$supsubject_id,$sy,$qtr,$course_id);	
		}	
		$data['grades']=$grades;			 
		$data['num_students'] 	= count($data['students']);
		$q = "SELECT crs.id AS subcourse_id,crs.course_weight AS weight,crs.name AS subcourse,crs.code AS label,
				crs.supsubject_id,cq.is_finalized_q{$qtr} AS is_locked						
			FROM {$dbg}.05_courses AS crs 
				LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
			WHERE crs.supsubject_id = '$supsubject_id' AND crs.crid = '$crid'			
			ORDER BY crs.id;";
		$sth = $db->querysoc($q);
		$data['subcourses']	= $sth->fetchAll();
		$data['num_subcourses'] = count($data['subcourses']);				
		$_SESSION['url'] = "aggregates/tally/$crid/$course_id/$supsubject_id/$sy/$qtr";				
		$this->view->render($data,'aggregates/tallyAggregates');
	 
} 	/* fxn */










}	/* AggregatesController */
