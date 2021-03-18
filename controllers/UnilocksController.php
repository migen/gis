<?php

Class UnilocksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Unilocks";	
	$this->view->render($data,"unilocks/indexUnilocks");
}	/* fxn */


public function lockCrs($params=NULL){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;$crs=$params[0];$sem=$_SESSION['college']['semester'];
	require_once(SITE.'functions/unilocksFxn.php');lockUnicourse($db,$dbg,$crs,$sem); 
	
}	/* fxn */

public function unlockCrs($params=NULL){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;$crs=$params[0];$sem=$_SESSION['college']['semester'];
	require_once(SITE.'functions/unilocksFxn.php');unlockUnicourse($db,$dbg,$crs,$sem); 
	
}	/* fxn */


public function major($params=NULL){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$major_id=isset($params[0])? $params[0]:false;
	$where=($major_id)? " WHERE cr.major_id=$major_id ":NULL;
	$q="SELECT crs.is_finalized,crs.id AS course,crs.id AS crs,sub.id AS sub,m.code AS major_code,
		crs.code AS course_code,crs.name AS course
		FROM {$dbg}.01_courses AS crs
		INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
		INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		$where ORDER BY cr.major_id,crs.level_id,crs.semester,sub.name;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->roWcount();
	
	$data['majors']=fetchRows($db,"{$dbg}.`05_majors`","*");
	
	$this->view->render($data,"unilocks/majorUnilocks");
	
	
}	/* fxn */






}	/* BlankController */
