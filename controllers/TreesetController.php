<?php

Class TreesetController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	


	
	$data="ABC";$this->view->render($data,"treeset/indexTreeset");
	
}	/* fxn */

public function levels(){
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$this->view->render($data,"treeset/levelsTreeset");	
	
}	/* fxn */


public function sections(){
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$data['rows']=fetchRows($db,"{$dbo}.`05_sections`","*","name");
	$this->view->render($data,"treeset/sectionsTreeset");	
	
}	/* fxn */


public function classrooms($params=NULL){
	$data['cluster_id']=$cluster_id=isset($params[0])? $params[0]:1;
	$db=&$this->baseModel->db;
	$data['sy']=$sy=isset($params['1'])? $params[1]:DBYR; 
	$data['qtr']=$qtr=isset($params['2'])? $params[2]:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	// $data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","*","cluster_id,level_id,section_id");
	if(!isset($_SESSION['clusters'])){ $_SESSION['clusters']=fetchRows($db,"{$dbo}.clusters","id,code,name","id"); }
	$data['clusters']=$_SESSION['clusters'];
	$cond=isset($_GET['all'])? "1=1":"cr.cluster_id=$cluster_id";
	$q="
		SELECT cr.*,l.name AS level,s.name AS section
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		WHERE $cond
		ORDER BY cr.cluster_id
	";
	
	
	$vfile="treeset/classroomsTreeset";vfile($vfile);
	$this->view->render($data,$vfile);
	
	
}	/* fxn */



}	/* BlankController */
