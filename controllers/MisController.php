<?php
Class MisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	/* 2nd param is strict,default is false */	
	$acl = array(array(5,0));
	$this->permit($acl);				
}	/* fxn */


public function index($params=NULL){
	$dbo=PDBO;
	$db=&$this->model->db;
	$data['home']=$home=$_SESSION['home'];	
	include_once(SITE.'views/elements/params_sq.php');
	$data['qtr']=$_SESSION['qtr'];		
	$data['months']=$_SESSION['months'];	
	$data['levels']=$_SESSION['levels'];	
	$data['subjects']=$_SESSION['subjects'];	
	$data['departments']=$_SESSION['departments'];	
	$data['roles']=$_SESSION['roles'];	
	$data['teachers']=$_SESSION['teachers'];	
	$dbg=VCPREFIX.$sy.US.DBG;
	if($sy!=DBYR){			
		$brid=$_SESSION['brid'];$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";
		$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);		
	} else { $data['classrooms']=$_SESSION['classrooms']; }
	
	$this->view->render($data,'mis/indexMis');
}	/* fxn */


	// $sth=$db->prepare($qry);
	// $sth->execute($data);print_r($sth->errorInfo());		

public function query(){	
	$dbo=PDBO;$db=&$this->model->db;$data=NULL;	
	// echo '<a href="'.URL.'mis/query" >MIS Query</a>';
	$data['query_link']='<a href="'.URL.'mis/query" >MIS Query</a>';
	if(isset($_POST['submit'])){
		$qry = $_POST['query'];pr($qry);
		$sth=$db->prepare($qry);
		$sth->execute($data);print_r($sth->errorInfo());				
		$rows=$sth->fetchAll();
		pr($rows);echo ($sth)? "Success":"Fail";
		pr('<a href="'.URL.'mis/query" >MIS Query</a>');		
		exit;				
	}	
	$this->view->render($data,'mis/query');
}	/* fxn */







 
} 	/* MisController */

