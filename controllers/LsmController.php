<?php

Class LsmController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$data=NULL;$this->view->render($data,'customs/lsm/indexLsm');
}	/* fxn */




/* affects 1) p.fname */
public function classroomProfiles($params = null){
	require_once(SITE."functions/details.php");
	// require_once(SITE."functions/profiling.php");
	require_once(SITE."functions/lsm/profilingLsm.php");
	$db=&$this->baseModel->db;

	$data['crid'] = $crid = $params[0];			
	$data['sy'] = $sy = isset($params[1])? $params[1] : $_SESSION['sy'];
	$_SESSION['classroom']['crid']	= $crid;
	$with_chinese = $_SESSION['settings']['with_chinese'];
	$data['home'] = $home 	= $_SESSION['home'];
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	
	
if(isset($_POST['save'])){
	$q="";
	$posts = $_POST['profiles'];	
	foreach($posts AS $post){
		$fullname = addslashes($post['fullname']);	
		$code = preg_replace("([^A-Za-z0-9-/])", "", $post['code']);		
		$q.="UPDATE {$dbo}.`00_contacts` SET `name`='$fullname',`code` = '$code',
			`account` = '$code',`lrn`='".$post['lrn']."',`position`='".$post['position']."',`is_male`='".$post['is_male']."',
			`grp` = '".$post['grp']."',`remarks` = '".$post['remarks']."' 
			WHERE `id` = '".$post['cid']."' LIMIT 1; ";
		$q.="UPDATE {$dbo}.`00_profiles` SET `birthdate`='".$post['birthdate']."',`father`='".$post['father']."', 
			`mother`='".$post['mother']."' WHERE `contact_id` = '".$post['cid']."' LIMIT 1; ";
	}
	// pr($q);exit;
	$db->query($q);
	$url="lsm/classroomProfiles/$crid/$sy";
	flashRedirect($url,'Updated.');
	exit;
}	/* post */
	
/* --------------------- process data ------------------------------------------ */

if($_SESSION['srid']==RTEAC && !in_array($crid,$_SESSION['teacher']['advisory_ids'])) { flashRedirect($home); }	

	$sort= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$sort.="c.is_male DESC,c.name";	
	$data['profiles'] 	= profilingByClassroom($db,$dbg,$sy,$crid,$sort);
	$data['num_profiles'] = count($data['profiles']);
	$data['classroom'] 	= getClassroomDetails($db,$crid,$dbg);		
	$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","*","level_id");		
	$data['cities'] 	= fetchRows($db,"{$dbo}.cities");			

	$sch=VCFOLDER;
	$ucfsch=ucfirst(VCFOLDER);
	$one="profiles/classroomProfiles{$ucfsch}";	
	$two="profiles/classroomProfiles";
	$vfile=cview($one,$two);
	vfile($vfile);
	$this->view->render($data,$vfile);		
	
}	/* fxn */











}	/* SjamController */
