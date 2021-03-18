<?php

Class TeachercoursesController extends Controller{	/* GISController from bootstrap */

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	// $this->view->css=array('etc.css','style_long.css');
	// $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	parent::beforeFilter();		
	
}


public function index(){	
	$dbo=PDBO;
	$tcid=$_SESSION['ucid'];
	echo "<a href='".URL."/teachercourses/view/{$tcid}' >Courses</a>";
	
	
}	/* fxn */


public function view(){
	$db=&$this->baseModel->db;
	$dbo=PDBO;$dbg=PDBG;
	$tcid=$_SESSION['ucid'];
	$data['sy']=DBYR;
	
	$q="SELECT crs.id AS crs,crs.name AS course,crs.semester
		FROM {$dbg}.05_courses AS crs 
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
		WHERE crs.tcid=$tcid 
		ORDER BY cr.level_id,cr.section_id,crs.semester;";
	debug("teaccourses/view: $q");
	pr($q);
	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$vfile="teacherCourses/viewTeacherCourses";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */




} 	/* TeachersController */
