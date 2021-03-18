<?php

Class AnnouncementsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index($params=NULL){
	$dbo=PDBO;
	$db=&$this->model->db;
	$page		= isset($params[0])? $params[0]:1;
	$ssy		= $_SESSION['sy'];
	$data['sy']	= $sy			= isset($_GET['sy'])? $_GET['sy'] : $ssy;
	
	
	$dbg = VCPREFIX.$sy.US.DBG;
		
	$perPage 	= 5;
	$page 		= $params[0];
	$offset 	= ($page - 1)*$perPage;
	$totalCount	= $this->model->totalCount("{$dbg}.announcements");
	
	$getsy = isset($_GET['sy'])? 'sy='.$_GET['sy'] : NULL;
	$_SESSION['announcements_url'] = "announcements/index/".$params[0].'?'.$getsy;

	$q = " SELECT * FROM {$dbg}.announcements 
			ORDER BY position LIMIT $perPage OFFSET $offset; ";
	// $q = " SELECT * FROM {$dbg}.announcements ; ";
	$sth = $this->model->db->querysoc($q);
	$data['announcements'] = $sth->fetchAll();		
	$pagination = new Pagination($page,$perPage,$totalCount);	
	$data['pages'] = $pagination->pageNav('mis','announcements');	
	$data['num_pages']	= count($data['pages']);
		
	$this->view->render($data,'announcements/index');


}	/* fxn */




public function add($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['submit'])){
	$created = date('Y-m-d H:i:s');
	$q  = " INSERT INTO {$dbg}.announcements(`announcement`,`announcement_by`,`position`,`is_active`,`created`) VALUES ";
	$q .= " ('".$_POST['announcement']."','".$_POST['announcement_by']."','".$_POST['position']."','".$_POST['is_active']."','".$created."'); ";
	
	$this->model->db->querysoc($q);
	$url = isset($_SESSION['announcements_url'])? $_SESSION['announcements_url'] : 'mis/announcements';
	redirect($url);
}	/* post */

	$this->view->render($data=NULL,'announcements/add');

}	/* fxn */


public function edit($params){
$dbo=PDBO;
$id  = $params[0];
$ssy = $_SESSION['sy'];
$sy  = isset($params[1])? $params[1]:$ssy;
$current = ($sy==$ssy)? true:false;
$dbg = ($current)? PDBG:VCPREFIX.$sy.US.DBG;

if(isset($_POST['edit'])){
	$created = date('Y-m-d H:i:s');
	$q  = " UPDATE {$dbg}.announcements SET ";
	$q .= " `announcement` 	= '".$_POST['announcement']."',`announcement_by` = '".$_POST['announcement_by']."',
		`position` = '".$_POST['position']."',`is_active` = '".$_POST['is_active']."',`created` = '".$created."' 
		WHERE `id` = '$id' LIMIT 1; ";
	
	$this->model->db->querysoc($q);
	$url = isset($_SESSION['announcements_url'])? $_SESSION['announcements_url'] : 'mis/announcements/1?sy='.$sy;
	redirect($url);

}

/*  ------- process */
$q = " SELECT * FROM {$dbg}.announcements WHERE `id` = '$id' LIMIT 1;  ";
$sth = $this->model->db->querysoc($q);
$data['announcement'] = $sth->fetch();

$this->view->render($data,'announcements/edit');

}	/* fxn */





}	/* AnnouncementsController */
