<?php

Class TheadController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index(){ 
	$data['home']=$_SESSION['home'];	
	$this->view->render($data,'thead/indexThead');
}	/* fxn */


public function sessionizeHome(){
	redirect('thead');
	/* 	$_SESSION['home']='thead';$_SESSION['user']['home']='thead';redirect('thead'); */
}	/* fxn */



public function roster($params=NULL){
$dbo=PDBO;

require_once(SITE."functions/classyear.php");
require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$home=$_SESSION['home'];$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['classroom']=getClassroomDetails($db,$crid);
$acid=$data['classroom']['acid'];

$lvl = $data['classroom']['level_id'];

if($crid){
	$data['rows'] = rosterList($db,$dbg,$crid);
	$data['count'] = count($data['rows']);
	
} /* if */
$srid=$_SESSION['srid'];
$data['mis']=($srid==RMIS)? true:false;

$this->view->render($data,'thead/rosterThead');


}	/* fxn */


public function cleanScores(){
	$srid=$_SESSION['srid'];$priv=$_SESSION['user']['privilege_id'];
	$is_thead=($srid==RTEAC AND $priv==0)? true:false;
	$allowed=array(RTEAC,RMIS,RREG);
	if(!in_array($srid,$allowed)){ flashRedirect(); }
	if($srid==RTEAC AND ($priv!=0)){ flashRedirect(); }	
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$q="DELETE FROM {$dbg}.50_scores WHERE activity_id < 1;";debug($q);
	echo (!isset($_GET['exe']))? "<a href='".URL."thead/cleanScores?exe' >Execute</a>":NULL;
	if(isset($_GET['exe'])){ $db->query($q); echo "Query executed.";  }
}	/* fxn */





}	/* RegistrationController */
