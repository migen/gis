<?php

Class PoolsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	echo "Pools index";
	

}	/* fxn */


public function roster($params=NULL){
$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;
$crid=isset($params[0])? $params[0]:false;
$data['crid']=&$crid;
$data['classroom']=fetchRow($db,"{$dbg}.05_classrooms","$crid");
// pr($data);exit;
$data['sy']=(isset($params[1]))? $params[1]:DBYR;
$data['classrooms']=$_SESSION['classrooms'];
$acid=$data['classroom']['acid'];
	
if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $scid){
		if($scid){
			$q.="UPDATE {$dbg}.05_summaries SET `prevcrid`=`crid`,`crid`='$crid',`acid`='$acid' WHERE `scid`='$scid' LIMIT 1;";
		}				
	}
	$db->query($q);
	$url="pools/students/$crid";
	flashRedirect($url,"Pool roster by keys done.");
	
	exit;
	
}	/* post */
	
	
$this->view->render($data,'pools/roster');

}



public function students($params=NULL){
$dbo=PDBO;

$crid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=(isset($params[1]))? $params[1]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;
$db=&$this->model->db;$dbo=PDBO;

$data['crid']=&$crid;
$data['classroom']=fetchRow($db,"{$dbg}.05_classrooms","$crid");
$data['classrooms']=$_SESSION['classrooms'];

if($crid){
	$q="SELECT summ.scid,c.code,c.name FROM {$dbo}.`00_contacts` AS c
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id WHERE summ.crid='$crid' ORDER BY c.is_male,c.name; ";	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
}	else { $data['rows'] = array(); }

$data['count']=count($data['rows']);
$this->view->render($data,'pools/students');

}	/* fxn */



}	/* BlankController */
