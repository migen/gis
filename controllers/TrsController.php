<?php

Class TrsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){

$data=NULL;
$this->view->render($data,'trs/index');

}	/* fxn */


public function ptr(){
$dbo=PDBO;

$dbg = PDBG;
$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","id,name,level_id,section_id","level_id,section_id","WHERE section_id<>1");
$this->view->render($data,'trs/ptr');
	
}	/* fxn */


public function teachers($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/trs.php');
	$db	=&	$this->model->db;
	$data['crid'] = $crid = $params[0];
	$ssy=$_SESSION['sy'];
	$sqtr=$_SESSION['qtr'];
	$data['sy'] = isset($params[1])? $params[1]:$ssy;
	$data['qtr'] = isset($params[2])? $params[2]:$sqtr;	
	
	$dbo=PDBO;
	$dbg = PDBG;
	$dbg = PDBG;

	$trsadvi = $_SESSION['settings']['trs_adviser'];	
	$tcid = $_SESSION['ucid'];
	$data['rows'] = $rows = getTeachersByCrid($db,$crid,$tcid,$trsadvi,$dbo=DBO,$dbg=PDBG);
	$data['count'] = count($rows);
	
	$q = "
		SELECT 
			cr.id AS crid,cr.name AS classroom,
			crs.id AS trsid,crs.name AS trait
		FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		WHERE 
				crs.crid = '$crid' 
			AND crs.crstype_id = '".CTYPETRAIT."' 
			LIMIT 1;
		
	";
	$sth = $db->querysoc($q);
	$data['cr'] = $cr = $sth->fetch();
	// pr($data);
	// pr($cr);
	
	$this->view->render($data,'trs/teachers');
	
	

}	/* fxn */

public function view($params){

require_once(SITE."functions/details.php");
require_once(SITE."functions/trs.php");
$db=&$this->model->db;

$dbo = PDBO;
$dbg = PDBG;
$dbg = PDBG;

$data['crsid'] = $crsid = $params[0]; 
$data['tcid'] = $tcid = $params[1]; 
$data['sy'] = $sy = isset($params[2])? $params[2]:$_SESSION['sy'];
$data['qtr'] = $qtr = isset($params[3])? $params[3]:$_SESSION['qtr'];

$data['crs'] = $crs = getCourseDetails($db,$crsid);
$data['crid'] = $crid = $crs['crid']; 

$data['lvlid'] = $lvlid = $crs['level_id'];

$data['criteria'] = $criteria = getTrsCriteriaByLevel($db,$lvlid,$dbg);
$data['numcri'] = $numcri = count($criteria);

$data['ar'] = buildArray($criteria,'criteria_id');

/* 4 students */
$sort="c.grp,c.name";
$data['students'] = $students = getClasslistByCrid($db,$crid,$sort,$dbo,$dbg);
$data['numrows'] = $numrows = count($students);

$trsgrades = array();
foreach($students AS $row){
	$scid = $row['scid'];	
	$trsgrades[] = getTrsByStudent($db,$qtr,$crsid,$tcid,$scid,$dbo,$dbg);
		
}	/* foreach */


$data['trsgrades'] = $trsgrades;
$data['tcount'] = $numrows*$numcri;

if(isset($_POST['sync'])){	/* sync */
	$posts = $_POST['posts'];	
	$q = "INSERT INTO {$dbg}.50_trsgrades(`course_id`,`tcid`,`scid`,`criteria_id`) VALUES ";
	foreach($posts AS $post){
		$scid = $post['scid'];
		$criteria_id = $post['criteria_id'];
		$q .= " ('$crsid','$tcid','$scid','$criteria_id'),";		
	}	/* foreach */
	$q = rtrim($q,",");
	$q .= ";";						
	$db->query($q);
	$url = "trs/view/$crsid/$tcid";
	$msg = (!empty($posts))? 'Traits grades synced.':null;
	flashRedirect($url,$msg);	
	exit;
	
}	/* post */

$data['cr'] = dtlCrByCrs($db,$crsid);
$data['teacher'] = dtlTeacher($db,$tcid);

$this->view->render($data,'trs/view');

}	/* fxn */


public function classrooms($params){
$dbo=PDBO;
require_once(SITE."functions/trs.php");
$db =& $this->model->db;
$data['tcid'] = $tcid = $params[0];
$data['ucid'] = $ucid = $_SESSION['ucid'];
$data['sy'] = $sy = isset($params[1])? $params[1]:$_SESSION['sy'];
$data['qtr'] = $qtr = isset($params[2])? $params[2]:$_SESSION['qtr'];

$dbg=PDBG;
$dbg=PDBG;

if(isset($_POST['sync'])){
	// pr($_POST);
	
	$posts = $_POST['posts'];
	$q="INSERT INTO {$dbg}.05_courses_traits(`trsid`,`tcid`) VALUES ";
	foreach($posts AS $post){
		if($post['trsid']){
			$q.= "('".$post['trsid']."','$tcid'),";			
		}			
	}	/* foreach */
	$q=rtrim($q,',');
	$q.=";";
	// pr($q);
	$db->query($q);
	$url = "trs/classrooms/$tcid/$sy/$qtr";
	flashRedirect($url,'Courses Traits synced.');	
	exit;

}	/* post */


/* 2 */
$q = "
	SELECT
		crs.crid AS crid,cr.name AS classroom,cr.acid AS acid,a.trsid,ct.is_finalized_q{$qtr} AS status
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		LEFT JOIN (
			SELECT
				crs.id AS trsid,crs.crid AS crid
			FROM {$dbg}.05_courses AS crs WHERE crstype_id = '".CTYPETRAIT."'
		) AS a ON a.crid = cr.id
		LEFT JOIN {$dbg}.05_courses_traits AS ct ON (
			ct.trsid = a.trsid		
		)		
	WHERE crs.`tcid` = '$tcid'
	GROUP BY cr.id
	ORDER BY cr.id
	
;";
// pr($q);
$sth = $db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

$data['teacher'] = dtlTeacher($db,$ucid);

$this->view->render($data,'trs/classrooms');

}	/* fxn */


public function editTrsColumn($params){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/trs.php");
$db =& $this->model->db;
$data['crsid'] = $crsid = $params[0];
$data['tcid'] = $tcid = $params[1];
$data['criteria_id'] = $criteria_id = $params[2];
$data['sy'] = $sy = isset($params[3])? $params[3]:$_SESSION['sy'];
$data['qtr'] = $qtr = isset($params[4])? $params[4]:$_SESSION['qtr'];
$data['course'] = $course = getCourseDetails($db,$crsid);
$data['crid'] = $crid = $course['crid'];
$data['dgonly'] = isset($_GET['dgonly'])? true:false;
$deptcode=($course['department_id']==3)? 'hs':'gs';
$data['imax'] = isset($_GET['imax'])? $_GET['imax']:$_SESSION['settings']['trs_max_'.$deptcode];


$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;


$q = "
	SELECT
		g.id AS gid,c.name AS student,g.scid,g.q{$qtr} AS grade
	FROM {$dbg}.50_trsgrades AS g 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
	WHERE 
			g.tcid = '$tcid'
		AND g.course_id = '$crsid'
		AND g.criteria_id = '$criteria_id'
		AND summ.crid = '$crid'
	ORDER BY c.name
;";
// pr($q);
$sth = $db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

if(isset($_POST['submit'])){
	// pr($_POST);
	$posts = $_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$q.= " UPDATE {$dbg}.50_trsgrades SET `q{$qtr}`= '".$post['grade']."' WHERE `id` = '".$post['gid']."' LIMIT 1; ";
	}
	$db->query($q);
	// pr($q);
	// exit;
	$url = "trs/view/$crsid/$tcid/$sy/$qtr";
	flashRedirect($url,'Traits edited');	
	exit;


}	/* post */


if(isset($_POST['batch'])){
	$ids = $_POST['rows'];
	$url = 'trs/deleteTrsgrades/';		
	foreach($ids AS $id){
		$url .= $id.'/';
	}		
	$url.='&crsid='.$crsid.'&tcid='.$tcid;
	// pr($url);
	redirect($url);		
}	/* batch */


$data['cr'] = dtlCrByCrs($db,$crsid);
$data['criteria'] = dtlCriteria($db,$criteria_id);
$data['teacher'] = dtlTeacher($db,$tcid);


$this->view->render($data,'trs/editTrsColumn');


}	/* fxn */


public function deleteTrsgrades($params){
$dbo=PDBO;
$q="";
$dbg = PDBG;
foreach($params AS $id){
	$q.="DELETE FROM {$dbg}.50_trsgrades WHERE `id` = '$id' LIMIT 1; ";
}
$this->model->db->query($q);
$crsid=$_GET['crsid'];
$tcid=$_GET['tcid'];
$url = "trs/view/$crsid/$tcid";
flashRedirect($url,'Traits grades deleted.');


}	/* fxn */



public function deleteTrsColumn($params){
$dbo=PDBO;
$db =& $this->model->db;
$dbg=PDBG;
$data['crsid'] = $crsid = $params[0];
$data['tcid'] = $tcid = $params[1];
$data['criteria_id'] = $criteria_id = $params[2];
$data['sy'] = $sy = isset($params[3])? $params[3]:$_SESSION['sy'];
$data['qtr'] = $qtr = isset($params[4])? $params[4]:$_SESSION['qtr'];

$q="DELETE FROM {$dbg}.50_trsgrades WHERE `course_id`='$crsid' AND `tcid`='$tcid' AND `criteria_id`='$criteria_id'; ";
$db->query($q);

$url = "trs/view/$crsid/$tcid/$sy/$qtr";
flashRedirect($url,'Traits edited');	
exit;


flashRedirect($url,'Traits column deleted.');


}	/* fxn */




public function tally($params){
$dbo=PDBO;
require_once(SITE.'functions/details.php');
require_once(SITE.'functions/trs.php');
require_once(SITE.'functions/equivs.php');
require_once(SITE.'functions/reports.php');
require_once(SITE.'functions/classifications.php');

$data['db']=$db =& $this->model->db;
$data['crsid'] = $crsid = $params[0];
$data['criteria_id'] = $criteria_id = $params[1];
$ssy = $_SESSION['sy'];
$data['sy'] = $sy = isset($params[2])? $params[2]:$ssy;
$data['qtr'] = $qtr = isset($params[3])? $params[3]:$_SESSION['qtr'];
$data['url']="trs/tally/$crsid/$criteria_id/$sy/$qtr";

$data['cr'] = $cr = dtlCrByCrs($db,$crsid);
$data['crid'] = $crid = $cr['crid'];
$data['acid'] = $acid = $cr['acid'];
$data['adviser'] = $adviser = dtlTeacher($db,$acid);

$data['course'] = $course = getCourseDetails($db,$crsid);
$crsClass	= classifyCourse($course);
$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
$data['ratings'] = $ratings = getRatings($db,$ctype,$dept_id);		

$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;

if(isset($_POST['tally'])){
	// pr($_POST);exit;
	$q="";
	$posts = $_POST['posts'];
	foreach($posts AS $post){
		$grade=$post['ave'];
		$dg = rating($grade,$ratings); 						
		$q.="UPDATE {$dbg}.50_grades SET 
				`q{$qtr}` = '$grade',`dg{$qtr}` = '$dg'
			WHERE 	`scid` = '".$post['scid']."' 
				AND `course_id` = '$crsid'
				AND `criteria_id` = '$criteria_id'
			LIMIT 1;";		
	}	/* foreach */
	// pr($q);exit;
	$db->query($q);
	
	if($qtr>3){
		$q="";
		foreach($posts AS $post){
			$q1="SELECT ((q1+q2+q3+q4)/4) AS avetr FROM {$dbg}.50_grades WHERE `scid` = '".$post['scid']."' 
				AND `course_id` = '$crsid' AND `criteria_id` = '$criteria_id' LIMIT 1; ";
			$sth=$db->querysoc($q1);
			$trow=$sth->fetch();
			$fg=$trow['avetr'];
			$fdg = rating($fg,$ratings); 							
			$q .= " UPDATE {$dbg}.50_grades SET `q5` = '$fg',`dg5` = '$fdg' WHERE `scid` = '".$post['scid']."' 
				AND `course_id` = '$crsid' AND `criteria_id` = '$criteria_id' LIMIT 1; "; 
		
		}					
	}	/* qtr>3 */

	// pr($q);exit;			
	$db->query($q);
	$ctype=isset($_GET['ctype'])?$_GET['ctype']:$ctype;
	$dept=isset($_GET['dept'])?$_GET['dept']:$course['department_id'];
	$url = "cav/traits/$crsid/$sy/$qtr?ctype=$ctype&dept=$dept";	
	// pr($url);exit;
	flashRedirect($url,'Tallied Traits Criteria.');	
	exit;

}	/* post */


// $data['students'] = $students = getClasslistByCrid($db,$crid,$sort=false,$dbo=DBO,$dbg=PDBG,$dbg=PDBG);
$q = "
SELECT c.id AS scid,c.name AS student,g.q{$qtr} AS grade,g.dg{$qtr} AS dg
FROM {$dbo}.`00_contacts` AS c
	LEFT JOIN {$dbg}.50_grades AS g ON g.scid = c.id
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
WHERE summ.crid = '$crid' 
AND g.course_id = '$crsid' AND g.criteria_id = '$criteria_id' 
ORDER BY c.grp,c.is_male DESC,c.name ASC;
";
// pr($q);
$sth = $db->querysoc($q);
$data['students'] = $students = $sth->fetchAll();
$data['count'] = $count = count($students);
	
$trsadvi = $_SESSION['settings']['trs_adviser'];	
$tcid = $_SESSION['ucid'];
// $data['teachers'] = $teachers = getTeachersByCrid($db,$crid,$tcid,$trsadvi,$dbo=DBO,$dbg=PDBG);	
$data['teachers'] = $teachers = getTrsTeachersByCrid($db,$crsid,$crid,$tcid,$trsadvi,$dbo=DBO,$dbg=PDBG);	
$data['numteacs'] = count($teachers);
$data['tcids']=buildArray($teachers,'tcid');


$grades = array();
for($i=0;$i<$count;$i++){
	$scid = $students[$i]['scid'];
	$grades[$i] = getTrsAggregates($db,$crsid,$criteria_id,$scid,$qtr,$tcid,$trsadvi,$dbo,$dbg);
}	/* for */

$data['grades'] = $grades;

$data['cr'] = dtlCrByCrs($db,$crsid);
$data['criteria'] = dtlCriteria($db,$criteria_id);

// pr($ratings);

$this->view->render($data,'trs/tally');

}	/* fxn */



public function cleanup($params){
$dbo=PDBO;
require_once(SITE.'functions/trs.php');
$db =& $this->model->db;
$data['crsid'] = $crsid = $params[0];
$data['criteria_id'] = $criteria_id = $params[1];
$ssy = $_SESSION['sy'];
$data['sy'] = $sy = isset($params[2])? $params[2]:$ssy;
$data['qtr'] = $qtr = isset($params[3])? $params[3]:$_SESSION['qtr'];

$data['cr'] = $cr = dtlCrByCrs($db,$crsid);
$data['crid'] = $crid = $cr['crid'];

$dbo=PDBO;$dbg = PDBG;$dbg = PDBG;
	
$trsadvi = $_SESSION['settings']['trs_adviser'];	
$tcid = $_SESSION['ucid'];
$data['teachers'] = $teachers = getTeachersByCrid($db,$crid,$tcid,$trsadvi,$dbo=DBO,$dbg=PDBG);	
$data['numteacs'] = count($teachers);


$tcids=buildArray($teachers,'tcid');
$br=$tcids;


$q="SELECT tcid FROM {$dbg}.50_trsgrades WHERE course_id = '$crsid' GROUP BY tcid; ";
$sth=$db->querysoc($q);
$a=$sth->fetchAll();
$ar=buildArray($a,'tcid');

$ix = array_diff($ar,$br);

$q="";
foreach($ix AS $teac){
	$q.="DELETE FROM {$dbg}.50_trsgrades WHERE `course_id`='$crsid' AND `tcid`='$teac'; ";
}
$db->query($q);

$url="trs/tally/$crsid/$criteria_id/$sy/$qtr";
$msg="Cleaned up Trs Grades.";
flashRedirect($url,$msg);


}	/* fxn */



public function tir(){
$dbo=PDBO;
require_once(SITE."functions/tir.php");	
$db=&$this->model->db;

$data['ssy']	= $ssy	= $_SESSION['sy'];
$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
$data['sy']   	= $sy   = isset($params[0])? $params[0]:$ssy;
$data['qtr']   	= $qtr  = isset($params[1])? $params[1]:$sqtr;

$allowed = array(RMIS,RREG,RACAD,RADMIN);
$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$dbg = VCPREFIX.$sy.US.DBG;
$data['classrooms'] = sessionizeTirList($_GET,$db,$dbg);
$data['count'] = count($data['classrooms']);

$this->view->render($data,'trs/tir');



}	/* fxn */




public function abc($params=NULL){	
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$db=&$this->model->db;
require_once(SITE.'functions/trs.php');
$data['crid']=$crid=isset($params[0])? $params[0]:1;
$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;

$q="SELECT crs.id AS crs,crs.name FROM {$dbg}.05_courses AS crs WHERE crs.crstype_id='2' AND crs.crid='$crid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['cr']=$cr=$sth->fetch();
$data['crs']=$crs=$cr['crs'];

$q="SELECT c.id AS scid,c.name AS student 
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
WHERE summ.crid='$crid' AND c.is_active=1 ORDER BY c.name; ";
$sth=$db->querysoc($q);
$data['students']=$students=$sth->fetchAll();
$data['count'] = $count = count($data['students']);


for($i=0;$i<$count;$i++){ $data['grades'][$i] = getStudentTrsMatrix($db,$dbg,$sy,$qtr,$crs,$students[$i]['scid']); } 


$data['teachers'] = $teachers = trsTeachersByCrid($db,$crs,$crid,$dbg);	
$data['numteacs'] = count($teachers);




 
$this->view->render($data,'trs/abc');

}	/* fxn */



public function matrix($params=NULL){	
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$db=&$this->model->db;

require_once(SITE."functions/details.php");
require_once(SITE."functions/classifications.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/equivs.php");
require_once(SITE.'functions/trs.php');
$data['crid']=$crid=isset($params[0])? $params[0]:1;
$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;

$data['cr']=$cr=getTrsCrsByCrid($db,$crid);
$data['crs']=$crs=$cr['crs'];

$course = $data['course'] = getCourseDetails($db,$crs,$dbg);
$crsClass	= classifyCourse($course);
$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
$data['sort'] = $sort = isset($_GET['sort'])? $_GET['sort'] : NULL;	
$data['ratings'] = $ratings = getRatings($db,$ctype,$dept_id);		

$q="SELECT c.id AS scid,c.name AS student 
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
WHERE summ.crid='$crid' AND c.is_active=1 ORDER BY c.name; ";
$sth=$db->querysoc($q);
$data['students']=$students=$sth->fetchAll();
$data['count'] = $count = count($data['students']);


for($i=0;$i<$count;$i++){ $data['grades'][$i] = getStudentTrsMatrix($db,$dbg,$sy,$qtr,$crs,$students[$i]['scid']); } 


$data['teachers'] = $teachers = trsTeachersByCrid($db,$crs,$crid,$dbg);	
$data['numteacs'] = count($teachers);




 
$this->view->render($data,'trs/trsmatrix');

}	/* fxn */


public function scidCriteria($params){
require_once(SITE.'functions/trs.php');
$data['crid']=$crid=$params[0];
$data['cri']=$cri=$params[1];
$data['scid']=$scid=$params[2];
$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=isset($params[3])? $params[3]:$ssy;
$data['qtr']=isset($params[4])? $params[4]:$sqtr;
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;

$data['student']=scidBasic($db,$scid);
$data['cr']=$cr=getTrsCrsByCrid($db,$crid);
$data['crs']=$crs=$cr['crs'];


$data['teachers'] = $teachers = trsTeachersByCrid($db,$crs,$crid,$dbg);	
$data['tcids']=$tcids=buildArray($teachers,'tcid');

$data['rows']=$rows=trsgradesCriteria($db,$crs,$cri,$scid);
$data['count']=count($rows);
// pr($trsgrades);

$this->view->render($data,'trs/scidcriteria');


}	/* fxn */


public function deleteTrsGradesByTeacher($params){
$dbo=PDBO;
require_once(SITE."functions/trs.php");	
$db=&$this->model->db;

$data['ssy']	= $ssy	= $_SESSION['sy'];
$data['sqtr']	= $sqtr	= $_SESSION['qtr'];

$data['crs']=$crs=$params[0];
$data['tcid']=$tcid=$params[1];
$data['sy']   	= $sy   = isset($params[2])? $params[2]:$ssy;
$data['qtr']   	= $qtr  = isset($params[3])? $params[3]:$sqtr;

$dbg=PDBG;
$q="DELETE FROM {$dbg}.50_trsgrades WHERE `course_id`='$crs' AND `tcid`='$tcid';";
// pr($q);
$this->model->db->query($q);
$url="trs/tir";
flashRedirect($url,'Trs Grades Deleted!');


}	/* fxn */


public function delsync($params){
$dbo=PDBO;
	require_once(SITE."functions/classlist.php");	
	require_once(SITE."functions/details.php");	
	$db=&$this->model->db;
	$dbg=PDBG;$dbg=PDBG;
			
	$crs = $params[0];
	$tcid = $params[1];
	$cri = $params[2];
	$sy=$_SESSION['sy'];
	$qtr=$_SESSION['qtr'];


$course=getCourseDetails($db,$crs);
$crid=$course['crid'];
$q="DELETE FROM {$dbg}.50_trsgrades WHERE course_id='$crs' AND tcid='$tcid' AND criteria_id='$cri'; ";
$db->querysoc($q);

$students=sxnlist($db,$dbg,$crid,$active=1);	
$count=count($students);
$q = "INSERT INTO {$dbg}.50_trsgrades(`course_id`,`tcid`,`criteria_id`,`scid`) VALUES ";
foreach($students AS $row){
	$scid = $row['scid'];
	$q .= " ('$crs','$tcid','$cri','$scid'),";			
}	/* foreach */
	$q = rtrim($q,",");$q .= ";";						
	$db->query($q);
	$url = "trs/editTrsColumn/$crs/$tcid/$cri/$sy/$qtr";
	$msg="Del synced";
	flashRedirect($url,$msg);	

}	/* fxn */


public function wdt(){ $this->view->render($data=NULL,'trs/wdt'); }		/* test-width */








}	/* TraitsController */
