<?php


Class AlienController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}



public function sumoRanking($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/equivs.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/classifications.php");
$db =& $this->model->db;$dbg = PDBG;
	
$data['home']	= $home	= $_SESSION['home'];
$data['crid']	= $crid	= isset($params[0])? $params[0]:0;
$ssy = $_SESSION['sy'];
$data['sy']		= $sy		= isset($params[1])? $params[1]:$ssy;
$data['qtr']	= $qtr		= isset($params[2])? $params[2]:$_SESSION['qtr'];


$q = "
	SELECT
		cr.id AS crid,cr.name AS classroom,
		l.is_sem,
		c.name AS chinese_adviser,c.chinese_name
	FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.chinese_acid = c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON cr.chinese_acid = p.contact_id
	WHERE 
			cr.id = '$crid'
	;";
	// pr($q);
$sth = $db->querysoc($q);
$classroom = $sth->fetch();
$data['classroom'] = $classroom;

if(!$crid) redirect($home);
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }

if(isset($_POST['open'])){
	// pr($_POST);
	$gid 	= $_POST['one']['gid'];
	$grade  = $_POST['one']['grade'];
	$orig   = $_POST['one']['orig'];
	$q = "UPDATE {$dbg}.50_grades SET 
			q$qtr = '".$grade."' WHERE `id` = '$gid' LIMIT 1;";
	// pr($q); exit;
	$db->query($q);
	$url = "alien/sumoRanking/$crid/$sy/$qtr";
	$_SESSION['message'] = "Change back to $orig and re-process!";
	redirect($url);
	exit;
}

if(isset($_POST['submit'])){
	// pr($_POST);
	
	$rows = $_POST['sumo'];
	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.05_summaries_other SET 
					`ave_q$qtr` = '".$row['ave']."',
					`ave_dg$qtr` = '".$row['dg']."',
					`rank_classroom_q$qtr` = '".$row['rank']."' 
				WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
	}
	// pr($q);exit;
	$this->model->db->query($q);
	$url = "alien/sumoRanking/$crid/$sy/$qtr";
	redirect($url);
	exit;
}	/* post */


// $etcCode = (($classroom['is_sem']==1) && ($qtr>2))? 'cn2':'cn';
$etcCode = 'cn';
// pr($etcCode);

/* 1 */
$q = "
	SELECT 
		crs.id AS crsid,crs.name AS course
	FROM {$dbg}.05_courses AS crs
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
	WHERE 
			crs.crid = '$crid'
		AND sub.code = '$etcCode'
		AND crs.is_aggregate = '1'
	LIMIT 1;
";
// pr($q);
$sth = $this->model->db->querysoc($q);
$data['chinese'] = $chinese = $sth->fetch();

// pr($chinese);
$cncrsid = $chinese['crsid'];

/* 2 - course details */
$data['course'] = $course = getCourseDetails($db,$cncrsid);

/* 3 */
$crsClass		  = classifyCourse($course);
$data['ratings']  = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);			

/* 4 */
$q= "
	SELECT 
		c.id AS scid,c.code AS student_code,c.name AS student,
		g.id AS gid,g.q$qtr AS grade,		
		sumo.ave_q$qtr AS ave,
		sumo.rank_classroom_q$qtr AS rank,
		sumo.scid AS sumoscid
	FROM {$dbg}.`05_summaries` AS summ 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.`crid` = cr.`id`
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.`scid` = c.`id`
		LEFT JOIN {$dbg}.`summaries_other` AS sumo ON sumo.`scid` = c.`id`
		LEFT JOIN {$dbg}.`50_grades` AS g ON g.`scid` = c.`id`
	WHERE 
			summ.`crid` 	= '$crid'
		AND	g.`course_id` 	= '$cncrsid'
	ORDER BY g.in_rank DESC,`grade` DESC;		
";
// pr($q);
$sth = $this->model->db->querysoc($q);
$data['grades'] = $sth->fetchAll();
$data['count']	= count($data['grades']);

$data['intfqtr'] = ($classroom['is_sem']==1 && $qtr<3)? 5:6;

$this->view->render($data,'alien/sumoRanking');


}	/* fxn */


public function syncSumo($params=NULL){
$data['home']	= $home	= $_SESSION['home'];
$data['crid']	= $crid	= isset($params[0])? $params[0]:0;
$dbg=PDBG;$dbo=PDBO;

/* 1 - classlist */
$q = "
	SELECT 
		c.id AS scid,c.name AS student
	FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
	WHERE summ.crid = '$crid' AND	c.is_active 	= '1' ORDER BY c.id; ";	

$sth = $this->model->db->querysoc($q);
$rows = $sth->fetchAll();
$ar = buildArray($rows,'scid');


/* 2 - sumo */
$q = "SELECT sumo.scid AS scid
	FROM {$dbg}.05_summaries_other AS sumo
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sumo.scid = c.id	
		LEFT JOIN {$dbg}.05_summaries AS summ ON sumo.scid = summ.scid
	WHERE summ.crid = '$crid' AND	c.is_active 	 = '1'; ";
$sth = $this->model->db->querysoc($q);
$rows = $sth->fetchAll();
$br = buildArray($rows,'scid');

/*  3 - ix */
$ix = array_diff($ar,$br);
$q = " INSERT INTO ".PDBG.".`summaries_other`(`scid`) VALUES ";
foreach($ix AS $scid){ $q .= " ('$scid'),"; }
$q = rtrim($q,",");
$q .= "; "; 

$this->model->db->query($q);
$url = "alien/sumoRanking/$crid";
redirect($url);


	
	
}	/* fxn */



public function delCridSumo($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/reports.php");
$db	=&	$this->model->db;
$dbg = PDBG;
$sy = $_SESSION['sy'];

$data['crid'] = $crid = $params[0];

if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
$students = classyear($db,$dbg,$sy,$crid,$male=2,$order="c.id",$fields=NULL,$filters=NULL,$limit=NULL,$active=0);
$scid_ids = buildArray($students,'scid');

$q = "";
foreach($scid_ids AS $scid){
	$q .= "DELETE FROM {$dbg}.05_summaries_other WHERE `scid` = $scid LIMIT 1;  ";
}
pr($q);



}	/* fxn */




public function etcAggregates($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/aggregates.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;
	
	
/* ------------------- params --------------------------------------------------------------- */
	$data['home']		= $_SESSION['home'];
	$data['crid']		= $crid			= $params[0];
	$data['course_id']	= $course_id	= $params[1];
	$data['supsubject_id'] 	=  $supsubject_id	= $params[2];
	$data['sy'] 	= $sy	= isset($params[3])? $params[3] : $_SESSION['sy'];
	$data['qtr'] 	= $qtr	= isset($params[4])? $params[4] : $_SESSION['qtr'];

	$data['srid']	= $srid	= $_SESSION['srid'];
	$data['admin']	= (($srid==RMIS) || ($srid==RREG))? true:false;
	
	$dbg = VCPREFIX.$sy.US.DBG;


	$data['course'] = $course	= getCourseDetails($db,$course_id,$dbg);
	
	
/* ------------------- check if num_aggregate grades == $num_students in classlist ------------------------------------- */

	$q = " SELECT c.id AS cid FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		WHERE summ.`crid` = '$crid' AND c.`is_active` = 1; ";
	
	$sth = $this->model->db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'cid');
	
	$q = " SELECT `scid` AS `cid` FROM {$dbg}.50_grades WHERE `course_id` = '$course_id'; ";
	$sth = $this->model->db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'cid');

	
	$ix = array_diff($ar,$br);
	if(!empty($ix)){ Session::set('message','Number of classlist students and grades do NOT match.');  $data['ix'] = $ix;	 }


	/* need 1) course details and 2) students for crid for post-2) updating final grade */
	$data['students'] 	= $students  = classGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order="c.name",$fields=NULL);
	
	/* security check is in the submissions page,so here no need to check in_array */
	if(isset($_POST['submit'])){
		$with_rating  = isset($_POST['with_rating'])? 1 : 0;				
		$qqtr 	= 'q'.$qtr;
		$dgqtr 	= 'dg'.$qtr;
		$rows	= $_POST['data']['aggregate'];
		// pr($rows);
		$q = "";
		/* 1-update quater */
		foreach($rows AS $row){
			if(!$with_rating) { $row[$dgqtr] = 'F'; }				
				$q .= " UPDATE {$dbg}.50_grades SET `$qqtr` = '".$row[$qqtr]."',`$dgqtr` = '".$row[$dgqtr]."' 
						WHERE `id` = '".$row['gid']."' LIMIT 1; ";
					
		}	/* foreach */					

		// pr($q); exit;
		$this->model->db->querysoc($q);
						
		$url = "alien/sumoRanking/".$course['crid']."/$sy/$qtr";			
		
		redirect($url);		
	}	/* post-submit */


/* -------------------- process ---------------------------------------------------------------------- */		
		$course   	= $data['course']  	  =  getCourseDetails($db,$course_id,$dbg);
		$is_locked  = $data['is_locked']  =  $course['is_finalized_q'.$qtr];

		$crsClass	= classifyCourse($course);
		$data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
			
		foreach($students AS $student){
			$data['grades'][] = getStudentAggregates($db,$dbg,$student['scid'],$supsubject_id,$sy,$qtr,$course_id);	
		}	
			 
		$data['num_students'] 	= count($data['students']);
		$data['num_subcourses'] = (empty($data['grades'][0]))? 0 : count($data['grades'][0]);
		$data['subcourses'] 	= (empty($data['grades'][0]))? array() : $data['grades'][0];
		$this->view->render($data,'alien/etcAggregates');
		
	 
} 	/* fxn */



public function ChineseIndex($params=NULL){
$dbo=PDBO;
$data['ssy']	= $ssy	= $_SESSION['sy'];
$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
$data['sy']   	= $sy   = isset($params[0])? $params[0]:$ssy;
$data['qtr']   	= $qtr  = isset($params[1])? $params[1]:$sqtr;
$dbg = PDBG;
 
$q = "
	SELECT 
		IF(sub.`code` = 'CN2', 2, 0) as sem2,
		cr.id AS crid,cr.name AS classroom,
		crs.id AS crsid,
		sub.id AS subid	
	FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.crid = cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
	WHERE 	
			(sub.code = 'CN' || sub.code = 'CN2')
		AND crs.is_aggregate = '1'
	ORDER BY cr.level_id,cr.section_id
	;";
	// pr($q);
$sth = $this->model->db->querysoc($q);
$data['classrooms'] = $sth->fetchAll(); 
$data['count']		= count($data['classrooms']);
$this->view->render($data,'alien/ChineseIndex');


}	/* fxn */




public function cnname($params=NULL){
$data['ucid'] = $ucid=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$dbo=PDBO;
if($ucid){
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE `id`='$ucid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$cnname=$post['cnname'];
	$q="UPDATE {$dbo}.`00_contacts` SET `chinese_name`='$cnname' WHERE `id`='$ucid' LIMIT 1; ";
	$db->query($q);
	$url="alien/cnname/$ucid";
	redirect($url);
	exit;
	
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'alien/cnname');

}	/* fxn */







} 	/* AlienController */
