<?php

Class CollegeController extends Controller{	

private $dbg=PDBG;

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}	/* fxn */



public function index(){

	$data="College";	
	$this->view->render($data,'college/indexCollege');
}	/* fxn */

public function steps(){	
	$this->view->render($data=NULL,'college/stepsCollege');
}	/* fxn */



public function cir(){
	$dbo=PDBO;
	require_once(SITE."functions/ccirFxn.php");	
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	
	$allowed = array(RMIS,RREG,RACAD,RADMIN);
	$data['srid']=$srid=$_SESSION['srid'];
	$home=$_SESSION['home'];
	if(!in_array($srid,$allowed)){ flashRedirect($home); }
	$data['all']=$all=isset($_GET['all'])? true:false;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO; 
 
 
	$d=getCcirList($db,$dbg);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];


	$vfile="college/cirCollege";
	$this->view->render($data,$vfile);
			
	
}	/* fxn */


public function classlist($params){
	$dbo=PDBO;
	// require_once(SITE."functions/collegeClasslistFxn.php");	
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['crid']=$crid=$params[0];
	$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$q="SELECT 
			summ.scid,c.name AS student,c.code AS studcode			
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.00_summaries AS summ ON summ.scid=c.id
		WHERE summ.crid='$crid' ORDER BY $order;		
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	$this->view->render($data,"college/classlistCollege");
	
}	/* fxn */


public function student($params=NULL){
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	
	include_once(SITE.'views/elements/dbsch.php');
	
	if($scid){
		$q="SELECT c.id,c.code,c.name,summ.crid,c.`sy` AS csy,cr.name AS classroom,cr.level_id 
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		pr($q);
		$sth=$db->querysoc($q);
		$row1=$sth->fetch();
		$row2=array();
		$row=array_merge($row1,$row2);
		$data['row']=&$row;				
	}	/* scid */
	
	// $view=isset($_GET['sch'])? "students/linksSch":"students/linksStudents";	
	$vfile="college/studentCollege";
	vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function grades($params=NULL){
	// require_once(SITE.'functions/collegeFxn.php');
	$scid=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="
		SELECT
		FROM {$dbg}.50_grades WHERE
	";
	
	
}	/* fxn */


public function courses($params=NULL){
	$major_id=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$cond=($major_id)? "WHERE major_id='$major_id' ":NULL;
	$q="SELECT * FROM {$dbo}.00_courses $cond ORDER BY major_id,name; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"college/coursesCollege");	
	
}	/* fxn */






}	/* BlankController */
