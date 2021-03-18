<?php

Class SubmissionsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ redirect('submissions/report'); }


public function report($params=null){
$dept=isset($params[0])? $params[0]:2;
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['qtr']=$qtr=(isset($_GET['qtr']))?$_GET['qtr']:$_SESSION['qtr'];

$q="
	SELECT c.name AS teacher,cq.is_finalized_q{$qtr} AS `is_locked`,cq.finalized_date_q{$qtr} AS `finalized_date`,
		crs.id AS crs,crs.name AS course,crs.tcid
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id=crs.id
	ORDER BY c.name
	
";
// pr($q);

$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);


$this->view->render($data,'submissions/report');

}	/* fxn */



/* params[0] course_id,params[1] = qtr (deafault current setting)  */
public function view($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/submissions.php");
	$db=&$this->model->db;

	$data['home'] = $home = $_SESSION['home'];
   	if(is_null($params)){ redirect($home); }			
	$data['crid']	= $crid 	= isset($params[0])? $params[0] : null;	
	$data['ssy']	= $ssy		=	$_SESSION['sy'];
	$data['sqtr']	= $sqtr		=	$_SESSION['qtr'];
	$user 	= $_SESSION['user'];
	$data['sy']  = $sy  = isset($params[1])? $params[1] : $ssy;
	$data['qtr'] = $qtr = isset($params[2])? $params[2] : $sqtr;
	
	$_SESSION['url'] = "submissions/view/$crid/$sy/$qtr";
	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	$data['srid']	= $srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD);
	$data['admin'] = $admin = in_array($srid,$adroles)? true:false;

	$cr = $data['classroom'] = getClassroomDetails($db,$crid,$dbg);	
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	
	
	/* qtr = 5 means get ranks for all four qtrs */
	$data['is_locked'] = $cr['is_finalized_q'.$qtr];
	
	$data['sem']	= $sem	= ($qtr<3)? 1:2;
	$condsem	= " AND (crs.semester = 0 || crs.semester = ".$sem.") ";
	
	/* all acad subjects including aggregates and children */
	$cond = " AND crs.crstype_id 	= '".CTYPEACAD."' AND ( crs.supsubject_id = 0 || crs.is_aggregate = 1) ";
	$cond .= $condsem;

	$data['parents'] 	  = submissionCourses($db,$dbg,$crid,$cond);
	$q=$_SESSION['q'];
	$data['num_parents']  = count($data['parents']);
	
	/* all children subjects only,parents / aggregates not included */
	$cond = " AND crs.crstype_id 	= '".CTYPEACAD."' AND ( crs.supsubject_id <> 0 AND crs.is_aggregate = 0 ) ";
	$cond .= $condsem;
	$data['children'] 	  = submissionCourses($db,$dbg,$crid,$cond);
	$q.=$_SESSION['q'];
	
	$data['num_children'] = count($data['children']);		
	
	/* all conducts or traits subjects */
	$cond = " AND crs.crstype_id <> '".CTYPEACAD."' ";
	$data['conducts'] 	  = submissionCourses($db,$dbg,$crid,$cond);
	$q.=$_SESSION['q'];
	$data['q']=$q;
	
	$cond .= $condsem;
	$data['num_conducts'] = count($data['conducts']);	

	$data['tcid'] 	= $_SESSION['user']['ucid'];	
	$vfile='submissions/viewSubmissions';vfile($vfile);
	$this->view->render($data,$vfile);

} 	/* fxn */


























}	/* SubmissionsController */
