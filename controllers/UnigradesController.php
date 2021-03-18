<?php

Class UnigradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Unigrades";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crs($params=NULL){
	$data['crs']=$crs=isset($params[0])? $params[0]:false;
	if(!$crs){ pr("Course ID not set."); exit; }
	require_once(SITE.'functions/unidetailsFxn.php');
	require_once(SITE.'functions/unigradesFxn.php');
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['course']=$course=getUnicourseDetails($db,$crs,$dbg);
	$data['is_numeric']=$is_numeric=($course['is_numeric']==1)? true:false;
	// $data['is_numeric']=$is_numeric=false;
	
	$order=$_SESSION['settings']['classlist_order'];	
	$d=getCourseUnigrades($db,$crs,$sem,$dbg,$order);
	$data['rows']=&$d['rows']; 
	$data['count']=&$d['count']; 

	$this->view->render($data,"unigrades/crsUnigrades");
	
}	/* fxn */










}	/* BlankController */
