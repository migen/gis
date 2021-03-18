<?php

class UtilsController extends Controller{	

	
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


/* init students to non-acad course -> to grades table,multiple criteria entries same course_id */
public function cleanTPG($params){	/* traits or psmapehs */
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db=&$this->model->db;
	$home	= $_SESSION['home'];
	$lid    = $data['id']  	 = $params[0];
	$crid   = $data['crid']  = $params[1];
	$crsid  = $data['crsid'] = $params[2];
	$ssy	= $data['ssy']	 = $_SESSION['sy'];
	$sy 	= $data['sy'] 	 = $params[3];
	$qtr 	= $data['qtr'] 	 = $params[4];
	$dbg	= VCPREFIX.$sy.US.DBG;

	$course = getCourseDetails($db,$crsid,$dbg);
	$ctype_id = $course['crstype_id'];
	// pr($course);

if($ctype_id!=CTYPEACAD){
	$q = " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid' ; ";
	$this->model->db->query($q);
}
		
	$url = isset($_SESSION['url'])? $_SESSION['url'] : "cav/traits/$crsid/$sy/$qtr";		
	redirect($url);

}	/* fxn */


/* init students to non-acad course -> to grades table,multiple criteria entries same course_id */
public function syncTPG($params){	/* traits or psmapehs */
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/tpgfxn.php");
	$db =& $this->model->db;

	$home	= $_SESSION['home'];
	$lid    = $data['id']  = $params[0];
	$crid   = $data['crid']  = $params[1];
	$crsid  = $data['crsid'] = $params[2];
	$ssy	= $data['ssy']	 = $_SESSION['sy'];
	$sy 	= $data['sy'] 	 = $params[3];
	$qtr 	= $data['qtr'] 	 = $params[4];
	$dbg	= VCPREFIX.$sy.US.DBG;

	$course = getCourseDetails($db,$crsid,$dbg);
	$ctype_id = $course['crstype_id'];
	$ix = tpgfxn($db,$dbg,$lid,$crid,$crsid,$sy,$qtr);	
	
	
	/* get TP criteria_ids */
 	$q = "SELECT DISTINCT(cri.id) AS criid,cri.name AS criteria 
		FROM {$dbo}.`05_criteria` AS cri
			INNER JOIN {$dbg}.05_components AS com ON com.criteria_id = cri.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id = sub.id
			INNER JOIN {$dbg}.05_courses AS crs ON crs.subject_id = sub.id
		WHERE com.level_id = '".$course['level_id']."'
			AND cri.crstype_id 	= ".$course['crstype_id']."
			AND crs.id = ".$crsid."; ";
	$sth = $this->model->db->querysoc($q);
	$criteria = $sth->fetchAll();	
	
	if(!empty($ix)){
		/* 1 - insert aggregate grades - scid,sy */
		$q = "";
		foreach($criteria AS $row){		
			$q .= " INSERT INTO {$dbg}.50_grades (`course_id`,`criteria_id`,`scid`,`crstype_id`)  VALUES  ";
			foreach($ix AS $cid){ $q .= " ('$crsid','".$row['criid']."','$cid','$ctype_id'),"; }
			$q = rtrim($q,",");
			$q .= ";";		
			
		}
		$this->model->db->query($q);
	}		
	$url = isset($_SESSION['url'])? $_SESSION['url'] : "cav/traits/$crsid/$sy/$qtr";	
	redirect($url);

}	/* fxn */


/* sync 2-way classlist and grades based on scid */
public function cleanCourseGrades($params){ 	/* averages/course - remove scid from grades not in classlist */
$dbo=PDBO;

require_once(SITE."functions/details.php");
$db =& $this->model->db;

$crid  = $params[0];
$crsid = $params[1];
$ssy   = $_SESSION['sy'];
$sy	   = isset($params[2])? $params[2]:$ssy;
$qtr   = isset($params[3])? $params[3]:$_SESSION['qtr'];
$home  = $_SESSION['home'];
$dbg   = VCPREFIX.$sy.US.DBG;

$course = getCourseDetails($db,$crsid,$dbg);
$ctype_id=$course['crstype_id'];

/* 1 - IMPT order, DONT reverse, grades more than classlist */
$q = " SELECT sum.scid AS cid FROM {$dbg}.05_summaries AS sum WHERE sum.`crid` = '$crid'; ";

$sth = $this->model->db->querysoc($q);
$a = $sth->fetchAll();
$ar = buildArray($a, 'cid');

$q = " SELECT g.scid AS cid FROM {$dbg}.50_grades AS g WHERE g.`course_id` = '$crsid' ; ";
$sth = $this->model->db->querysoc($q);
$b = $sth->fetchAll();
$br = buildArray($b, 'cid');


$ix = array_diff($br, $ar);

if(!empty($ix)){
	/* 1 - execute if need to clean grades */
	$q = "";
	foreach($ix AS $cid){ 
		$q .= " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid' AND `scid` = '$cid' LIMIT 1; ";  
	}
	/* 2 - insert summaries - scid, sy */	
}	
$db->query($q);
 
/* 2 - IMPT order, DONT reverse, classlist more than grades */
$q = " SELECT sum.scid AS cid FROM {$dbg}.05_summaries AS sum
		INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		WHERE sum.`crid` = '$crid' AND c.`is_active` = 1; ";
$sth = $this->model->db->querysoc($q);
$a = $sth->fetchAll();
$ar = buildArray($a, 'cid');

$q = " SELECT g.`scid` AS cid FROM {$dbg}.50_grades AS g
INNER JOIN {$dbo}.`00_contacts` AS c ON g.`scid` = c.id
WHERE g.`course_id` = '$crsid' ; ";
$sth = $this->model->db->querysoc($q);
$b = $sth->fetchAll();
$br = buildArray($b, 'cid');

$ix = array_diff($ar, $br);
if(!empty($ix)){
	/* 1 - insert grades - scid, sy */
	$q = " INSERT INTO {$dbg}.50_grades (`course_id`,`scid`,`crstype_id`) VALUES ";
	foreach($ix AS $cid){ $q .= " ( '".$crsid."','".$cid."','$ctype_id'), "; }
	$q = rtrim($q,", ");
	$q .= ";";
	
	$this->model->db->query($q);

}	


/* 3 - redirect */
		
	$url = isset($_SESSION['url'])? $_SESSION['url'] : 'index';	
	redirect($url);
 
}	/* fxn */


public function syncPromotions($params=NULL){		/* DBM.promotions */
$dbo=PDBO;
	require_once(SITE."functions/syncs.php");
	$db =& $this->model->db;

	$ssy = $_SESSION['sy'];
	syncPromotions($db,PDBG,PDBG,$ssy);
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Promotions Synced');  }	
}	/* fxn */


public function syncSummariesAcid($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');

/* 1 - update summaries acid */

	$q = " 
		UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT 
				c.id AS contact_id,c.crid,cr.acid
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
				INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		) AS b ON a.scid = b.contact_id 
		SET a.acid = b.acid						
	";		
	pr($q);

	$db=&$this->model->db;
	$db->query($q);
	echo "Query done.";


/* 3 - redirect */
	// redirect('dashboard/stats');

}	/* fxn */


/* for bonuses individual syncGrades like mis/syncGrades */ 
public function checkStudentGrades($params){		
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	require_once(SITE."functions/classrooms.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/utils.php");
	$db =& $this->model->db;
	
	
/* from ccr */ 
	$data['home']	= $home		= $_SESSION['home'];
	$data['crid']	= $crid		= $params[0];
	$data['scid']	= $scid		= $params[1];
	$data['ucid']	= $ucid		= $scid;
	$data['srid']	= $srid		= $_SESSION['srid'];	
	$data['sy']		= $sy		= isset($params[2])? $params[2]:DBYR;
	
	$data['current']	= $current = ($sy==$ssy)? true:false;
	$dbg  = VCPREFIX.$sy.US.DBG;
	$data['qtr']	= $qtr		= isset($params[3])? $params[3] : 4;	
	$_SESSION['url']	= "gtools/msg/$crid/$scid/$sy/$qtr";	
		
	$allowed = array(RMIS,RREG,RTEAC); 
	$srid 	 = $_SESSION['user']['role_id']; 	
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); } 


/* ------------- for batch edits ------------- */
	if(isset($_POST['batch'])){
		$rows = $_POST['rows'];
		foreach($rows AS $gid){ deleteGrade($db,$dbg,$gid); }
		Session::set('message','Delete Grades Successfully!');
		$url = isset($_SESSION['url'])? $_SESSION['url']:"matrix/grades/$crid/$sy";
		redirect($url);		
		exit;
	}

	if(isset($_POST['move'])){
		// pr($_POST);
		$scid = $_POST['scid'];   /* crid from */
		$crf  = $_POST['crf'];   /* crid from */
		$crt  = $_POST['crt'];	/* crid to   */
		
		$crstudent = studentInClassroom($db,$dbg,$crf,$scid);
		if(empty($crstudent)){
			$_SESSION['message'] = "No student found!";		
		} else {
			/* 1 - subjects */		
			$rows = allsubjects($db,$crf,$dbg,$sem=1);
					
			/* 2 delete all crt courses */
			dsgs($db,$dbg,$crt,$scid);
			
			/* 3 - msg */
			foreach($rows AS $row){ msg($db,$dbg,$scid,$crf,$crt,$row['subject_id']); }
			
			/* 4 - resection scid from crf to crt */
			sxn($db,$dbg,$scid,$crf,$crt);
			$_SESSION['message'] = "Transferred grades done!";
		}
			
		$url = "gtools/msg/$crt/$scid/$sy/$qtr";		
		flashRedirect($url,'Student Records Transferred.');		
		exit;
	}
	
/* ------------- data -------------------------------------------- */	

	$q = "
		SELECT 
			c.id AS scid,c.name AS student,c.code AS student_code,
			sum.crid AS crid,
			cr.level_id
		FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		WHERE c.id = '".$scid."' LIMIT 1;
	";
	$sth = $this->model->db->querysoc($q);	
	$data['student'] 		= $student	= $sth->fetch();
	
	$data['courses'] 	 	= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter=null);	
	$data['num_courses']	= count($data['courses']);

	$q = "
		SELECT 
			crs.subject_id,crs.id AS course_id,crs.name AS course,crs.is_active,crs.crstype_id AS ctype_id,crs.label,
			crs.crid AS crid,
			g.id AS gid,g.q5 AS fg,g.*
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		WHERE 
				g.scid = '".$scid."' 
		ORDER BY crs.position;
	";
	$sth = $this->model->db->querysoc($q);		
	$data['grades']		 = $sth->fetchAll();	
	$data['count']	 = count($data['grades']); 
	// $data['mismatch'] = ($data['count']!=$data['num_courses'])? true:false;
	
	if($_SESSION['srid']==RTEAC){ if(!in_array($student['crid'],$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } } 
	$data['home'] = $home;	
	
	$level_id = $student['level_id'];
	$classrooms = isset($_GET['all'])? $this->model->fetchRows("{$dbg}.05_classrooms","id,name"):getClassroomsByLevel($db,$level_id,$dbg);
	$data['classrooms'] = $classrooms;
	$this->view->render($data,'gtools/msg');

}	 /* fxn */


public function syncStudentTraits($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/utils.php");
	require_once(SITE."functions/traits.php");
	$db =& $this->model->db;

	$this->view->js = array('js/jquery.js','js/vegas.js');	

	$data['crsid']		= $crsid		= $params[0];
	$data['course_id']	= $crsid;
	$data['scid']		= $scid			= $params[1];
	$data['sy']		= $sy	  	= isset($params[2])? $params[2] : DBYR;
	$data['qtr']	= $qtr	  	= isset($params[3])? $params[3] : $_SESSION['qtr'];
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$data['course_id']	= $course_id	=	$crsid; 
	
	/* controller - teachers or else */
	$data['home']	=	$home = $_SESSION['home']; 			
	
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$crsid,$dbg);
	
	$ctype_id 		= $course['crstype_id'];
	$data['crid']	= $crid	= $course['crid'];
	
	$is_trait = ($course['is_trait'])? 1 : 0;
	$data['is_trait']	= $is_trait;	
	if($home=='teachers'){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  $this->flashRedirect('teachers'); } }
	$_SESSION['course'] = $data['course'];		

	/* --------------------- POST --------------------- */
	
	if(isset($_POST['edit'])){
		$rows = $_POST['grades'];
		$q = "";
		foreach($rows AS $row){ $q .= " UPDATE {$dbg}.50_grades SET `q$qtr` = '".$row['grade']."' WHERE `id` = '".$row['gid']."' LIMIT 1; "; }
		$this->model->db->query($q);		
		$url = isset($_SESSION['url'])? $_SESSION['url']:"cav/traits/$crsid/$sy/$qtr";				
		redirect($url);

		exit;		
	}	/* post-edit */
	
	if(isset($_POST['add'])){
		$rows = $_POST['grades'];
		$q = "INSERT INTO {$dbg}.50_grades (`scid`,`course_id`,`criteria_id`,`crstype_id`,`q$qtr`) VALUES";
		foreach($rows AS $row){ $q .= "  ('".$scid."','".$crsid."','".$row['criid']."','$ctype_id','".$row['grade']."'),"; }
		$q = rtrim($q,",");
		$q .= ";";
		$this->model->db->query($q);				
		$url = isset($_SESSION['url'])? $_SESSION['url']:"cav/traits/$crsid/$sy/$qtr";
		redirect($url);
		exit;		
	}	/* post */
	
	if(isset($_POST['batch'])){
		$rows = $_POST['rows'];
		foreach($rows AS $gid){ deleteGrade($db,$dbg,$gid); }
		Session::set('message','Delete Grades Successfully!');
		$url = isset($_SESSION['url'])? $_SESSION['url']:"cav/traits/$crsid/$sy/$qtr";
		redirect($url);		
		exit;
	}
	
	
		
	/* --------------------- PROCESS2 --------------------- */

	$crsClass	= classifyCourse($course);
	$data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
	
						
	$data['is_locked'] = $course['is_finalized_q'.$qtr];
	$data['criteria'] = getTraitsCriteria($db,$crsid,$dbg);
	
	
	$data['num_criteria'] = count($data['criteria']);
	$data['student'] 		= student($db,$dbg,$sy,$scid);

	
	$data['grades']		= syncStudentTraits($db,$dbg,$crsid,$scid,$sy,$qtr);
	$data['num_grades']	= count($data['grades']);
	$data['gids']		= buildArray($data['grades'],'criteria_id');

	
	
	$this->view->render($data,'utils/syncStudentTraits');

}	/* fxn */



public function deleteTraitsRow($params){
$dbo=PDBO;
	$db =& $this->model->db;
	$data['course_id']	 = $course_id  	 = $params[0];
	$data['criteria_id'] = $criteria_id	 = $params[1];
	$sy		= $params[2];
	$qtr 	= $params[3];
	
	$dbg  = PDBG;	
	$url = "cav/traits/$course_id/$sy/$qtr";	

	$srid = $_SESSION['srid']; 
	$allowed = array(RMIS,RACAD,RREG);
	$admin = (in_array($srid,$allowed))? true:false;
	$owned = (in_array($course_id,$_SESSION['teacher']['conduct_ids']))? true:false;

	if($admin || $owned){
		$q = "DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$course_id' AND `criteria_id` = '$criteria_id'; ";
		$db->query($q);
		flashRedirect($url,'Traits Column deleted.');		
	} else {
		flashRedirect($url);
	}
		
}	/* fxn */


public function syncTraitsColumn($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;
	$data['course_id']	 = $course_id  	 = $params[0];
	$dbg  = PDBG;
	$dbg  = PDBG;		
	$course = getCourseDetails($db,$course_id,$dbg);	
	$data['criteria_id'] = $criteria_id	 = $params[1];
	$sy		= isset($params[2])? $params[2]:$_SESSION['sy'];
	$qtr	= isset($params[3])? $params[3]:$_SESSION['qtr'];
	
/*  1 */
// $q = "  SELECT id FROM {$dbo}.`00_contacts`  WHERE `crid` = '".$course['crid']."' AND `is_active` = '1';  ";
$q = "  SELECT scid AS id FROM {$dbg}.`05_summaries`  WHERE `crid` = '".$course['crid']."';  ";
$sth  = $db->querysoc($q);
$rows = $sth->fetchAll();
$ar   = buildArray($rows,'id');

/*  2   */
$q = " SELECT scid AS id FROM {$dbg}.`50_grades` WHERE `course_id` = '$course_id' AND `criteria_id` = '$criteria_id'; ";
$sth  = $db->querysoc($q);
$rows = $sth->fetchAll();
$br   = buildArray($rows,'id');

/*  3 - ix */
$ix = array_diff($ar,$br);
$q = " INSERT INTO {$dbg}.`50_grades`(`scid`,`course_id`,`criteria_id`) VALUES ";
foreach($ix AS $cid){ $q .= " ('$cid','$course_id','$criteria_id'),"; }
$q = rtrim($q,",");
$q .= "; "; 
$db->query($q);

	/* 4 */
	$url = "cav/traits/$course_id/$sy/$qtr";	
	flashRedirect($url,'Traits Column synced.');		
		
}	/* fxn */


public function syncTraitsByStudent($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;
	$crsid = $params[0];
	$scid = $params[1];
	$sy = $_SESSION['sy'];
	$qtr = $_SESSION['qtr'];
	
	$dbg = PDBG;
	$course = getCourseDetails($db,$crsid,$dbg);	
	$lvlid = $course['level_id'];
	
	
/*  1 */
// $q = "  SELECT id FROM {$dbg}.`compon`  WHERE `crid` = '".$course['crid']."' AND `is_active` = '1';  ";
$q="
	SELECT
		cri.id AS id,cri.code AS code,cri.name AS criteria
	FROM {$dbg}.05_components AS com
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
	WHERE 
			com.level_id = '$lvlid'
		AND cri.crstype_id = '".CTYPETRAIT."'
		ORDER BY cri.position,cri.id		
";
$sth  = $db->querysoc($q);
$rows = $sth->fetchAll();
$ar   = buildArray($rows,'id');


/*  2   */
$q = " SELECT criteria_id AS id FROM {$dbg}.`50_grades` WHERE `scid` = '$scid' AND `course_id` = '$crsid'; ";
$sth  = $db->querysoc($q);
$rows = $sth->fetchAll();
$br   = buildArray($rows,'id');

/*  3 - ix */
$ix = array_diff($ar,$br);

// pr($ix);
// exit;

$q = " INSERT INTO {$dbg}.`50_grades`(`scid`,`course_id`,`criteria_id`) VALUES ";
foreach($ix AS $cri){ $q .= " ('$scid','$crsid','$cri'),"; }
$q = rtrim($q,",");
$q .= "; "; 
$db->query($q);

	/* 4 */
	
echo "<h3>Student Traits Synced. You may close this window.</h3>";	
	

}	/* fxn */


public function syncRemarksCrid($params){
$crid = $params[0];
$db=&$this->model->db;
$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;

$q = " SELECT summ.`scid` AS `scid` FROM {$dbg}.05_summaries AS summ 
INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
WHERE summ.`crid` = '$crid';";
$sth = $db->querysoc($q);
$a = $sth->fetchAll();
$ar = buildArray($a,'scid');

$q = " SELECT r.`scid` FROM {$dbg}.50_remarks AS r 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = r.scid
INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
WHERE summ.`crid` = '$crid' AND c.is_active = '1';";
$sth = $db->querysoc($q);
$b = $sth->fetchAll();
$br = buildArray($b,'scid');

$ix = array_diff($ar,$br);
$q = "INSERT INTO {$dbg}.50_remarks(`scid`) VALUES ";
foreach($ix AS $scid){ $q .= "('$scid'),"; }
$q=rtrim($q,',');
$q.=";";
$db->query($q);

$url="remarks/classroom/$crid";
flashRedirect($url,'Classroom Remarks Synced.');


}	/* fxn */



// string function and array function
public function compext(){	// compact extract
	pr("compact");
	$data=array(
		'id'=>23,
		'name'=>'Makol'
	);
	pr($data);
	pr('<hr />');
	$ed=extract($data);
	pr($id);
	pr($name);

	pr('<hr />');	
	$nd=compact("id","name");
	pr($nd);
	
	
	$this->view->render($data,"utils/compext");
	

}	/* fxn */








}	/* UtilsController */