<?php

Class UniclasslistsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	$data="Uniclasslists";	
	$this->view->render($data,"unicourses/indexUnicourses");
}	/* fxn */


public function crid($params=NULL){
$dbo=PDBO;
	if(!isset($params[1])){ pr("Params INCOMPLETE - crid/lvl."); exit; }
	$data['crid']=$crid=$params[0];
	$data['lvl']=$lvl=$params[1];
	require_once(SITE.'functions/uniclasslistsFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;
	$d=getUniclasslist($db,$dbg,$crid,$lvl);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	$q="SELECT *,name AS classroom FROM {$dbg}.01_classrooms WHERE id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();	
		
	$this->view->render($data,"uniclasslists/cridUniclasslist");
	
}	/* fxn */


public function crs($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Parameter course id NOT set."); exit; }
	$data['crs']=$crs=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];	
	require_once(SITE.'functions/uniclasslistsFxn.php');
	require_once(SITE.'functions/unidetailsFxn.php');
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$d=getUnicourselist($db,$crs,$sem,$dbg);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	/* 1 */
	$data['course']=getUnicourseDetails($db,$crs,$dbg);
	$data['is_current']=($sy==DBYR)? true:false;

	$vfile=(isset($_GET['edit']))? "uniclasslists/crslistEditUniclasslist":"uniclasslists/crsUniclasslist";
	$this->view->render($data,$vfile);
	
}	/* fxn */


// public function 





}	/* BlankController */
