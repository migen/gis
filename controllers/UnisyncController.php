<?php

Class UnisyncController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Unisync";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */



public function scores($params=NULL){
$dbo=PDBO;
	$crs=isset($params[0])? $params[0]:false;
	if(!$crs){ pr("Course ID not set."); exit; }
	require_once(SITE.'functions/unidetailsFxn.php');
	require_once(SITE.'functions/unigradesFxn.php');
	require_once(SITE.'functions/uniscoresFxn.php');
	require_once(SITE.'functions/unisyncFxn.php');
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$sy=DBYR;$sem=$_SESSION['settings']['semester'];	
	/* 1 */
	$order=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];	
	$d=getCourseUnigrades($db,$crs,$sem,$dbg,$order);
	$students=&$d['rows'];$num_students=&$d['count'];	
	/* 2 */
	$activities=getUniactivities($db,$dbg,$crs,$sem);	
	$ar=buildArray($activities,'aid');
	foreach($students AS $student){ $scores[]=getUniscoresForSyncing($db,$dbg,$crs,$student['scid'],$sem); }		
	
	for($i=0;$i<$num_students;$i++){
		$scid=$students[$i]['scid'];
		$br=buildArray($scores[$i],'aid');
		syncStudentUniscores($db,$ar,$br,$scid,$crs,$sem);
		delsyncStudentUniscores($db,$ar,$br,$scid,$crs,$sem);
	}	/* endfor */
	flashRedirect("uniscores/crs/$crs","Uniscores synced.");
	
}	/* fxn */

public function studentScores($params=NULL){
$dbo=PDBO;
	if(!isset($params[0]) && !isset($params[1])){ pr("Crs and Scid missing."); exit; }
	require_once(SITE.'functions/uniscoresFxn.php');
	require_once(SITE.'functions/unisyncFxn.php');
	$crs=$params[0];$scid=$params[1];$sy=DBYR;$sem=$_SESSION['settings']['semester'];	
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;			
	$activities=getUniactivities($db,$dbg,$crs,$sem);	
	$ar=buildArray($activities,'aid');	
	$scores=getUniscoresForSyncing($db,$dbg,$crs,$scid,$sem); 	
	$br=buildArray($scores,'aid');	
	syncStudentUniscores($db,$ar,$br,$scid,$crs,$sem);
	echo "Synced done.";
		
}	/* fxn */














}	/* BlankController */
