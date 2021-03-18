<?php

Class SyncersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

}



public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	// $acl = array(array(5,0));
	// $this->permit($acl);					
}	/* fxn */



public function index(){
	require_once(SITE."functions/syncMatrixFxn.php");
	$_SESSION['url'] = 'syncers/index'; 
	$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;$db=&$this->model->db;
	$ssy = $_SESSION['sy'];
	$data['sy']			= $ssy;
	$data['qtr']		= $_SESSION['qtr'];
	$data['home']	= $_SESSION['home'];
	$data['classrooms'] = matrixClassrooms($db,$dbg);
	$data['count']		= count($data['classrooms']);
	$this->view->render($data,'syncers/indexSyncers');


}	/* fxn */


public function abc(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	
	$q="
		SELECT c.name,summ.scid,summ.crid
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE c.name LIKE '%a' LIMIT 100;
	";
	pr($q);
	
	
	
	
	
}	/* fxn */



public function syncGrades($params){	
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/syncMatrixFxn.php");
$data['crid'] 	= $crid = $params[0];
$today = $_SESSION['today'];
$db=&$this->model->db;
$dbg=PDBG;$dbg=PDBG;	
$sy=DBYR;	
$data['cr'] 	= $cr 	= getClassroomDetails($db,$crid,$dbg);
/* ----------------------------------------------------------------------------------- */
$data['students'] = $students = matrixClassyear($db,$dbg,$sy,$crid,$order="c.name");		/* GModel */

$data['courses'] = $courses = matrixCourses($db,$dbg,$crid,$order="crs.position,crs.id ");
$ar = buildArray($courses,'course_id');


// prx($students);
// pr($ar);
/* 1 - sync Grades  ------------------------------------------------------------------ */
foreach($students AS $row){ 
	$scid = $row['scid'];
	$q = " SELECT course_id FROM {$dbg}.50_grades WHERE `crstype_id` <> '".CTYPETRAIT."'  AND `scid` = '$scid' ORDER BY course_id; ";
	// pr($q);
	$sth = $db->querysoc($q);
	$courses = $sth->fetchAll();
	$br = buildArray($courses,'course_id');	
	$ix = array_diff($ar,$br);	
	
	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_grades (`course_id`,`scid`) VALUES  ";
		foreach($ix AS $crs){ $q .= " ('$crs','$scid'),"; }
		$q = rtrim($q,",");
		$q .= ";";	
		$db->query($q);
	}
	// prx($ix);
}	/* foreach-students */

/*  2-update ctype */
updateGradesCtype($db,$dbg,$crid);

flashRedirect("index/blank","Sync grades for Crid#$crid.");


}	/* fxn */



public function loop(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;$sy=DBYR;
	require_once(SITE."functions/syncer.php");
	
	if(isset($_POST['submit'])){
		$ctype = $_POST['ctype'];
		$classrooms = (empty($_POST['classrooms']))? false:$_POST['classrooms'];
		if($ctype && $classrooms){
			foreach($classrooms AS $crid){
				syncGrades($db,$dbg,$crid,$sy,$ctype);
			}	/* foreach */
		} /* if */		
		echo "Synced Grades, Tsum, Summaries.";
		exit;
	
	}	/* post */
		

	$key = 'syncer';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];
		
	$data['ctypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`",'*','id');
	$data['gscr'] = $this->model->fetchRows("{$dbg}.05_classrooms",'id,name','level_id,section_id','WHERE level_id < 10 AND section_id <> 1');
	$data['hscr'] = $this->model->fetchRows("{$dbg}.05_classrooms",'id,name','level_id,section_id','WHERE level_id > 9 AND section_id <> 1');
	
	// $this->view->render($data,'misc/loopSyncer');
	$vfile="syncers/loopSyncers";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */






}	/* BlankController */
