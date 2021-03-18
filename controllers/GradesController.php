<?php

Class GradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	ob_start();
	echo "<h3>Grades | ";shovel('links_grades');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");

}	/* fxn */



/* for bonuses individual syncGrades like mis/syncGrades */ 
public function student($params=NULL){		
	$dbo=PDBO;
	if(empty($params)){ pr('No parameters.'); echo "<a href='".URL."grades/filter' >Filter</a>"; exit; }
	require_once(SITE."functions/fine.php");
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/editStudentGrades.php");
	$db =& $this->model->db;

/* from ccr */ 
	$data['ssy'] = $ssy = $_SESSION['sy'];
	$data['sqtr'] = $sqtr = $_SESSION['qtr'];

	$data['home'] = $home = $_SESSION['home'];
	$data['scid'] = $scid = $params[0];	
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$data['qtr'] = $qtr = isset($params[2])? $params[2]:$sqtr;
	
	$data['current']	= $current = ($sy==$ssy)? true:false;
	$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

	$data['student'] = $student	= student($db,$dbg,$sy,$scid);
	$data['crid']=$crid=$student['crid'];	
	$_SESSION['url'] = "grades/student/$scid/$sy/$qtr";		
	$srid 	 = $_SESSION['user']['role_id']; 	
		
	if(isset($_POST['tally'])){
		/* 1 - edit grades */
		$rows = $_POST['grades'];
		$q = "";
		foreach($rows AS $row){ $q .= " UPDATE {$dbg}.`50_grades` SET 
			`q1` = '".$row['q1']."',`q2` = '".$row['q2']."',`q3` = '".$row['q3']."',
			`q4` = '".$row['q4']."',`q5` = '".$row['q5']."',`q6` = '".$row['q6']."',			
			`bonus_q1` = '".$row['bonus_q1']."',`bonus_q2` = '".$row['bonus_q2']."',
			`bonus_q3` = '".$row['bonus_q3']."',`bonus_q4` = '".$row['bonus_q4']."',						
			`dg1` = '".$row['dg1']."',`dg2` = '".$row['dg2']."',`dg3` = '".$row['dg3']."',`dg4` = '".$row['dg4']."',
			`dg5` = '".$row['dg5']."',`dg6` = '".$row['dg6']."' 													
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; }
		$db->query($q);		
		
	}	/* post-edit */
		
	if(isset($_POST['edit'])){
		/* 1 - edit grades */
		$rows = $_POST['grades'];
		$q = "";		
		foreach($rows AS $row){ $q .= " UPDATE {$dbg}.`50_grades` SET 
			`dg1` = '".$row['dg1']."',`dg2` = '".$row['dg2']."',`dg3` = '".$row['dg3']."',`dg4` = '".$row['dg4']."',
			`dg5` = '".$row['dg5']."',`dg6` = '".$row['dg6']."' 				
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; }				
		$db->query($q);						

		/* 2 - fineSummariesAttendance */
		fineSumAtt($db,$dbg,$sy,$scid,$crid);
	
		/* 3 - open classroom */
		unlockClassroom($db,$crid,$qtr,$dbg);
				
		/* 4 - redirect */		
		$url = "summarizers/student/$scid/$sy/$qtr";		
		redirect($url);
		exit;		
	}	/* post-edit */
	
	if(isset($_POST['add'])){
		/* 1 - add grades */
		$rows = $_POST['grades'];
		$q = "INSERT INTO {$dbg}.`50_grades` (`scid`,`course_id`,`q$qtr`) VALUES";
		foreach($rows AS $row){ $q .= "  ('".$scid."','".$row['crsid']."','".$row['grade']."'),"; }
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);				
		$url = "grades/student/$scid/$sy/$qtr";
		redirect($url);		
	}	/* post-add */
		
		
/* ------------- data -------------------------------------------- */		
	$data['cr'] 			= getClassroomDetails($db,$crid,$dbg);
	$data['is_locked'] 		= $data['cr']['is_finalized_q'.$qtr];
	$data['courses'] 	 	= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter=null);	
	$data['num_courses']	= count($data['courses']);

	$all=(isset($_GET['all']))? true:false;
	$data['grades'] = editStudentGrades($db,$dbg,$crid,$scid,$sy,$qtr,$ctype=1,$agg=1,$all);		
	$data['q']=$_SESSION['q'];
	
	$data['course_ids']  = buildArray($data['courses'],'course_id');	
	$data['num_grades']	= count($data['grades']);
	$data['gids'] = buildArray($data['grades'],'course_id');
	$data['ratings'] = getRatings($db,'1',$data['student']['department_id']);			

	$this->view->render($data,'grades/studentGrades');

}	 /* fxn */


public function deleteCourseGrades($params=NULL){	/* delete */
	$dbg = PDBG;$dbg = PDBG;
	$q = "";
	foreach($params AS $crsid){
		$q .= " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid'; ";
		$q .= " DELETE FROM {$dbg}.50_activities WHERE `course_id` = '$crsid'; ";
		$q .= " DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$crsid'; ";
		$q .= " DELETE FROM {$dbg}.50_scores WHERE `course_id` = '$crsid'; ";	
	}
	echo "&nbsp;&nbsp;&nbsp;";pr($q);

}	/* fxn */


public function delete($params){
	$dbo=PDBO;
	$acl = array(array(5,0));
	$this->permit($acl,$strict=false);				
	$data['gid']=$gid=$params[0];
	$sy = isset($params[1])? $params[1]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;		
	$q = "DELETE FROM {$dbg}.50_grades WHERE `id` = '$gid' LIMIT 1; ";
	$this->model->db->query($q);
	$url = isset($_SESSION['url'])? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = 'Grade deleted.';
	redirect($url);

}	/* fxn */


public function inRank($params=NULL){
$dbo=PDBO;
$data['crs']=$crs=isset($params[0])? $params[0]:false;
$data['scid']=$scid=isset($params[1])? $params[1]:false;

// require_once(SITE."functions/editStudentGrades.php");
$db =& $this->model->db;
$dbg=PDBG;$dbg=PDBG;

if($crs && $scid){
	$q="
		SELECT g.in_rank,c.name AS student,crs.name AS course
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid=c.id
		WHERE g.scid='$scid' AND g.course_id='$crs';
	";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	

}	/* data */

if(isset($_POST['submit'])){
	$q="UPDATE {$dbg}.50_grades SET `in_rank`='".$_POST['in_rank']."' WHERE `course_id`='$crs' AND `scid`='$scid' LIMIT 1; ";
	$db->query($q);
	$url="grades/inRank/$crs/$scid";
	flashRedirect($url,'In Rank updated.');
	exit;
	
}	/* post */


$this->view->render($data,'grades/in_rank');

}	/* fxn */


public function dg($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	$db =& $this->model->db;

	$data['with_chinese'] = $with_chinese = $_SESSION['settings']['with_chinese'];
	
	$data['home']		= 	$home		= $_SESSION['home'];
	$data['course_id']	=	$course_id	= $params[0];	
	$data['sy']			= $sy  			= isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']		= $qtr  		= isset($params[2])? $params[2]:$_SESSION['qtr'];	
	$data['curr_sy']	=	$curr_sy 	= 	$_SESSION['sy'];
	$data['ssy']	= $ssy	= $_SESSION['sy'];

	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data['course']		= $course  		= getCourseDetails($db,$course_id);			
	$data['with_dg'] = isset($_GET['dg'])? $_GET['dg']:$course['is_k12'];
	
	$data['subject_id']	= $course['subject_id'];	
	$ctype_id			= $course['crstype_id'];
	$data['is_locked']	= $is_locked  	= $course['is_finalized_q'.$qtr];
	$data['crid']		= $crid  		= $course['crid'];
	$data['crsid']		= $crsid		= $course_id;
	$data['is_k12']		= $is_k12		= $course['is_k12'];
	
	$data['home'] =	$home = $_SESSION['home']; 				
	$_SESSION['url'] = "grades/dg/$course_id/$sy/$qtr";	

	$data['srid']	= $srid	= $_SESSION['srid'];
	$data['admin']	= $admin	= (($srid==RMIS) || ($srid==RREG))? true:false;

	
/* ------------- access control --------------------------------------------------------------------- */	
$srid = $_SESSION['srid'];
if($srid==RTEAC){ if((!in_array($course_id,$_SESSION['teacher']['course_ids']))) { $this->flashRedirect('teachers'); } }	
/* -------------------------------------------------------------------------------------------------- */
	
	$order=$_SESSION['settings']['classlist_order'];			
	// $order= (isset($_GET['sort']))? $_GET['sort']:$order;
	$data['sortcond'] = $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order);	
	$data['num_students'] = $num_students	= count($students);

	$fields = ($with_chinese==1)? ",c.chinese_name":NULL;	
	$data['grades']=$grades=classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order,$fields);		
	$data['num_grades'] = $num_grades	=	count($grades);
	

if(isset($_POST['submit'])){				
	$rows = $_POST['grades'];
	$q = "";
	foreach($rows AS $row){
		$dg=$row['dg'];
		$q .= " UPDATE {$dbg}.50_grades SET `dg$qtr` = '$dg' WHERE `id` = '".$row['gid']."' LIMIT 1; ";	
	}
	$db->query($q);
	if($_POST['submit']=='Finalize'){
		require_once(SITE."functions/locks.php");
		require_once(SITE."functions/sessionize.php");	
		require_once(SITE."functions/sessionize_teacher.php");		
		lockCourse($db,$course_id,$qtr,$dbg);
		sessionizeTeacher($db,$dbg);	
	} 
		
	$url = "grades/dg/$crsid/$sy/$qtr";
	redirect($url);		
	
}	/* post */

	
	$this->view->render($data,"grades/dgGrades");
		
}	/* fxn */



public function edit($params){
$dbo=PDBO;
$this->view->js = array('js/jquery.js','js/vegas.js');	
require_once(SITE."functions/logs.php");
require_once(SITE."functions/aggregates.php");

$data['crsid']=$crsid=$params[0];
$data['scid']=$scid=$params[1];
$data['gid']=$gid=$params[2];
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

$q="SELECT g.id AS gid,g.*,c.name AS student,crs.name AS course,crs.*,c.id AS scid
	FROM {$dbg}.50_grades AS g 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
	WHERE g.id = '$gid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$row = $sth->fetch();
$data['crid']=$crid=$row['crid'];

if(isset($_POST['submit'])){
	$post = $_POST['post'];
	
	/* 1 */
	$q = "UPDATE {$dbg}.50_grades SET ";
	for($i=1;$i<7;$i++){
		$q.="`q{$i}`='".trim($post['q'.$i])."',`bonus_q{$i}`='".trim($post['bonus_q'.$i])."',`dg{$i}`='".trim($post['dg'.$i])."',";
	}
	$q=rtrim($q,",");
	$q.=" WHERE `id` = '$gid' LIMIT 1; ";	
	$db->query($q);
	
	/* 2 */
	$details="";
	for($i=1;$i<7;$i++){			
		if($post['q'.$i]!=$row['q'.$i]){ $details.="Q{$i}: ".$row['q'.$i]; }		
	}	/* for */

	/* 3 */
	$message = "";
	if(strlen($details)>1){
		$details .= $post['memo'];
		$ucid = $_SESSION['ucid'];
		$axn = $_SESSION['axn']['change_grade'];
		$more['scid'] = $scid;	
		$more['crsid'] = $crsid;	
		$more['qtr'] = $qtr;
		logThis($db,$ucid,$axn,$details,$more);		
		$message = "Grade changed.";
	}	/* if */

	/* 4 */
	if($row['supsubject_id']>0){
		updateStudentAggregates($db,$scid,$crid);
		updateStudentAggregates($db,$scid,$crid);
		
	}

	/* 5 */
	summarizeGenave($db,$scid,$crid);
	summarizeGenave($db,$scid,$crid);
	
	$url = "grades/edit/$crsid/$scid/$gid";
	flashRedirect($url,$message);
	exit;
	
}	/* post */


$this->view->render($data,'grades/editGrades');


}	/* fxn */



public function scid($params=NULL){	
	$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	if($scid){
		$q="SELECT c.id AS scid,cr.name AS classroom,c.name,summ.crid FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries As summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms As cr ON summ.crid=cr.id
		WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['student']=$sth->fetch();
		$data['crid']=$crid=$data['student']['crid'];
		
		$q="SELECT crs.id AS crs,crs.name AS course,crs.label,crs.is_num,
			g.q1,g.q2,g.q3,g.q4,g.dg1,g.dg2,g.dg3,g.dg4			
			FROM {$dbg}.05_courses AS crs 
			INNER JOIN {$dbg}.50_grades AS g ON g.course_id=crs.id
			WHERE crs.crid=$crid AND g.scid=$scid; ";
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
		
	}

	$this->view->render($data,"grades/scidGrades");	
	
	
}	/* fxn */










}	/* GradesController */
