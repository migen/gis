<?php

Class UnistudentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
$dbo=PDBO;
	
	$data="Unistudents";	
	$this->view->render($data,'unistudents/indexUnistudents');
}	/* fxn */


public function courses($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Student ID NOT Set."); exit; }
	$data['scid']=$scid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['is_current']=(DBYR==$sy)? true:false;
	
	$cond=(isset($_GET['all']))? NULL:" AND g.semester=$sem ";
	$q="SELECT g.id AS gid,c.name AS course,c.id AS crs,c.semester
		FROM {$dbg}.10_grades AS g
		INNER JOIN {$dbg}.01_courses AS c ON g.course_id=c.id
		WHERE g.scid='$scid' $cond; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	/* 2-studinfo */
	$q="SELECT summ.scid,c.code,c.name,cr.name AS classroom,summ.level_id
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.01_classrooms AS cr ON summ.crid=cr.id
		WHERE c.id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	
	$this->view->render($data,"unistudents/coursesUnistudent");
		
	
	
}	/* fxn */


public function grades($params=NULL){
	if(!isset($params[0])){ pr("Student ID NOT Set."); exit; }
	$data['scid']=$scid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['is_current']=(DBYR==$sy)? true:false;
	$q="
		SELECT g.id AS gid,g.*,c.name AS course,c.id AS crs,t.name AS teacher
		FROM {$dbg}.10_grades AS g
		INNER JOIN {$dbg}.01_courses AS c ON g.course_id=c.id
		INNER JOIN {$dbo}.`00_contacts` AS t ON c.tcid=t.id
		WHERE g.scid='$scid' AND g.semester='$sem';";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	/* 2-studinfo */
	$q="SELECT summ.scid,c.code,c.name,cr.name AS classroom
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.01_classrooms AS cr ON summ.crid=cr.id
		WHERE c.id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	
	$this->view->render($data,"unistudents/gradesUnistudent");
		
	
	
}	/* fxn */



public function scid($params=NULL){
	// if(!isset($params)){ pr("Student parameter NOT set."); exit; }
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	if($scid){
		$data['student']=fetchRow($db,"{$dbo}.`00_contacts`",$scid,"id,code,name,lrn,is_active,role_id");
		
	}	/* scid */
	
	
	$this->view->render($data,"unistudents/scidUnistudent");
	
}	/* fxn */


public function edit($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$contact=$_POST['contact'];
		$profile=$_POST['profile'];
		if(isset($_POST['summary'])){						
			$summary=$_POST['summary'];			
			$db->update("{$dbg}.01_summaries",$summary,"scid=$scid");			
		} 		
		$db->update("{$dbo}.`00_contacts`",$contact,"id=$scid");
		$db->update("{$dbo}.`00_profiles`",$profile,"contact_id=$scid");
		
		flashRedirect("unistudents/edit/$scid","Updated.");
		exit;
		
	}
	
	if($scid){
		$data['contact']=fetchRow($db,"{$dbo}.`00_contacts`",$scid,"id,code,account,name,lrn,is_active,role_id,is_male");
		$data['summary']=fetchRecord($db,"{$dbg}.01_summaries","scid=$scid");
		reqFxn('dbFxn');
		$d=getDbTableFields($db,$dbo,"profiles","'id','contact_id'");
		$field_string=$d['field_string'];$data['field_array']=$d['field_array'];		
		$q="SELECT $field_string FROM {$dbo}.`00_profiles` WHERE contact_id=$scid LIMIT 1; ";
		$sth=$db->querysoc($q);
		$data['profile']=$sth->fetch();
		$data['uniclassrooms']=fetchRows($db,"{$dbg}.01_classrooms");
		$data['is_college']=($data['contact']['role_id']==8)? true:false;
		$data['has_college']=$has_college=(isset($_SESSION['settings']['has_college']) && $_SESSION['settings']['has_college']==1)? true:false;
		$q="SELECT summ.scid AS summscid,summ.crid AS summcrid";
		if($has_college){ $q.= ",unisumm.scid AS unisummscid,unisumm.crid AS unisummcrid";}
		$q.=" FROM {$dbo}.`00_contacts` AS c LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id ";
		if($has_college){ $q.= " LEFT JOIN {$dbg}.01_summaries AS unisumm ON unisumm.scid=c.id "; }
		$q.="WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['summrow']=$sth->fetch();
		pr($data['summrow']);
		
		// pr($data['uniclassrooms']);
		
	}	/* scid */
	
	$this->view->render($data,"unistudents/editUnistudent");
	
	
}	/* fxn */




}	/* BlankController */
