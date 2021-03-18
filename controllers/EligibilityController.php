<?php

Class EligibilityController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */



/* affects 1) p.fname */
public function classroom($params = null){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/profiling.php");
	$db=&$this->model->db;

	$data['crid'] 	= $crid		= $params[0];			
	$data['sy'] 	= $sy 		= isset($params[1])? $params[1] : $_SESSION['sy'];
	$_SESSION['classroom']['crid']	= $crid;
	$with_chinese	= $_SESSION['settings']['with_chinese'];
	$data['home']	= $home 	= $_SESSION['home'];

	$dbo=PDBO;
	$dbg = VCPREFIX.$sy.US.DBG;


if(isset($_POST['save'])){
	// pr($_POST);
	$q="";
	$posts = $_POST['profiles'];
	foreach($posts AS $post){
		$code = preg_replace("([^A-Za-z0-9-/])", "", $post['code']);		
		$q.="UPDATE {$dbo}.`00_contacts` SET `name` = '".$post['fullname']."',`code` = '$code',
			`account` = '$code',`lrn` = '".$post['lrn']."',`position` = '".$post['position']."',
			`grp` = '".$post['grp']."',`remarks` = '".$post['remarks']."' 
			WHERE `id` = '".$post['cid']."' LIMIT 1; ";
	}
		
	// pr($q); 
	// exit;
	$this->model->db->query($q);
	$url="profiles/classroom/$crid/$sy";
	flashRedirect($url,'Updated.');
	exit;
}	/* post */
	
/* --------------------- process data ------------------------------------------ */

if($_SESSION['srid']==RTEAC && !in_array($crid,$_SESSION['teacher']['advisory_ids'])) { $this->flashRedirect($home); }	

	$sort= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$sort.="c.is_male DESC,c.name";	
	$data['profiles'] 	= profilingByClassroom($db,$dbg,$sy,$crid,$sort);
	$data['num_profiles'] = count($data['profiles']);

	$data['classroom'] 	= getClassroomDetails($db,$crid,$dbg);		
	$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");		
	$data['cities'] 	= $this->model->fetchRows("".PDBO.".cities");			
	
	$this->view->render($data,'eligibility/classroom');		
	
}	/* fxn */









}	/* EligibilityController */
