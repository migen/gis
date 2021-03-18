<?php

Class UniattendanceController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Uniattendance";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crs($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Course ID Not set."); exit; }
	$data['crs']=$crs=$params[0];
	$data['sy']=$sy=DBYR;
	$data['sem']=$sem=$_SESSION['settings']['semester'];	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$attid=(int)$post['attid'];$dp=(int)$post['days_present'];$dt=(int)$post['days_tardy'];			
			$q.="UPDATE {$dbg}.10_attendance SET days_present=$dp,days_tardy=$dt WHERE id=$attid LIMIT 1; ";			
		}
		$db->query($q);
		flashRedirect("uniattendance/crs/$crs","Saved.");
		exit;		
	}	/* post */
		
	/* 2 */
	$q="SELECT a.*,g.id AS gid,g.scid,a.id AS attid,a.scid AS attdscid,c.name AS student FROM {$dbo}.`00_contacts` AS c  
		LEFT JOIN {$dbg}.10_grades AS g ON g.scid=c.id 
		LEFT JOIN {$dbg}.10_attendance AS a ON (a.scid=c.id AND a.course_id=$crs)
		WHERE g.course_id=$crs;
		";debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	/* 3 */
	$ar=buildArray($rows,"scid");	
	$br=buildArray($rows,"attdscid");
	$ix=array_diff($ar,$br);					
	if($ix){		
		$q="INSERT INTO {$dbg}.10_attendance(scid,course_id,semester)VALUES";
		foreach($ix AS $scid){ $q.="($scid,$crs,$sem),"; }
		$q=rtrim($q,",");$q.=";"; // pr($q);
		$db->query($q);
		flashRedirect("uniattendance/crs/$crs","Synced.");		
	}	/* ix */
		
	$this->view->render($data,"uniattendance/crsUniattendance");
	
}	/* fxn */










}	/* BlankController */
