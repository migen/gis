<?php

Class FoundationController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function index($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/cir.php');
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$data['rows']=getCirList($db,$dbg,$cond=NULL);
	$data['count'] = count($data['rows']);	
	$this->view->render($data,"foundation/indexFoundation");
}	/* fxn */



public function crid($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/details.php');
require_once(SITE.'functions/classlist.php');
require_once(SITE.'functions/foundationFxn.php');
$data['crid']=$crid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:5;
$db=$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['courses']=$courses=getFoundationCourses($db,$dbg,$crid);
// pr($courses);exit;
$data['numcrs']=$numcrs=count($data['courses']);
$order=$_SESSION['settings']['classlist_order'];
$data['students']=getClasslistSimple($db,$dbg,$crid,$order);
$data['count']=count($data['students']);
$data['cr']=getClassroomDetails($db,$crid,$dbg);

$grades=array();
for($i=0;$i<$numcrs;$i++){
	$crs=$courses[$i]['crs'];$sem=$courses[$i]['sem'];
	$grades[$i]=getCourseGrades($db,$dbg,$crs,$sem,$order);
}
$data['grades']=&$grades;

$this->view->render($data,'foundation/cridFoundation');


}	/* fxn */

public function subjects($params=NULL){
	$dbo=PDBO;	
	require_once(SITE.'functions/foundationFxn.php');
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$all=isset($_GET['all'])? true:false;
	$data['rows']=getAllSubjects($db,$dbg,$all);
	$data['count']=count($data['rows']);
	$this->view->render($data,'foundation/subjectsFoundation');

}	/* fxn */



}	/* BlankController */
