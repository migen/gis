<?php

Class UnicoursesController extends Controller{	

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
	$db=&$this->baseModel->db;$dbg=PDBG;
/* 	$q="SELECT * FROM {$dbg}.01_colleges ORDER BY `id`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		 */
	// $data="College Courses <br />1) uniClassrooms/courses, 2) uni Courses edit 3) prerequisites fxn";
	// pr($data);
	$data=NULL;
	
	$this->view->render($data,"unicourses/indexUnicourses");
}	/* fxn */


public function edit($params){
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js','js/jqueryui.js');
	if(!isset($params[0])){ pr("Parameter course id NOT set."); exit; }	
	$data['crs']=$crs=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		// reqFxn('utilitiesFxn');
		$post=$_POST['post'];		
		$db->update("{$dbg}.01_courses",$post,"id='$crs'");
		flashRedirect("unicourses/edit/$crs","Saved.");exit;
	}	/* post */
	
	
	$q="SELECT t.name AS teacher,crs.*,cr.code AS crcode,cr.name AS classroom,sub.code AS subcode,sub.name AS subject
		FROM {$dbg}.01_courses AS crs
		LEFT JOIN  {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbo}.`00_contacts` AS t ON crs.tcid=t.id
		WHERE crs.id='$crs' LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects'] = fetchRows($db,"{$dbo}.`05_subjects`"); } 
	if(!isset($_SESSION['uniclassrooms'])){ $_SESSION['uniclassrooms'] = fetchRows($db,"{$dbg}.01_classrooms","id,code,name"); } 
	if(!isset($_SESSION['unidays'])){ $_SESSION['unidays'] = fetchRows($db,"{$dbg}.01_days","*"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	
	$data['uniclassrooms']=$_SESSION['uniclassrooms'];	
	// $data['unidays']=$_SESSION['unidays'];	
	$data['unidays']=fetchRows($db,"{$dbg}.01_days","*","id");	
		
	$this->view->render($data,"unicourses/editUnicourse");
	
}	/* fxn */


public function upname(){	
$dbo=PDBO;
	$dbg=PDBG;
	pr("exe to execute");
	$q="UPDATE {$dbg}.01_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
		LEFT JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id
		SET crs.name=CONCAT(m.code,'-',s.code,'-',sub.code);";				
	pr($q);
	if(isset($_GET['exe'])){
		$db=&$this->baseModel->db;
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail"; pr($msg." - $q");		
	}	/* fxn */
	
	
}	/* fxn */
	

public function all(){
$dbo=PDBO;
	require_once(SITE.'functions/unicoursesFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;
	$d=getUnicourses($db,$dbg,$where=NULL);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
		
	$this->view->render($data,"unicourses/setUnicourses");
	
}	/* fxn */


public function add($params=NULL){
$dbo=PDBO;
	$data['crid']=$crid=isset($params[0])? $params[0]:0;
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];	
		$db->add("{$dbg}.01_courses",$post);
		$id=$db->lastInsertId();
		$q="UPDATE {$dbg}.01_courses AS crs
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
			INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id			
			SET crs.name=CONCAT(cr.code,'-',sub.code) WHERE crs.id='$id';";	
		$sth=$db->query($q);
		$msg="Course added.";
		flashRedirect("unicourses/edit/$id",$msg);			
		exit;		
	}	/* post */	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects'] = fetchRows($db,"{$dbo}.`05_subjects`"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	
	$data['uniclassrooms']=$_SESSION['uniclassrooms'];			
	$this->view->render($data,"unicourses/addUnicourse");
	
}	/* fxn */



public function create($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/unicoursesFxn.php');
	$data['major_id']=$major_id=isset($params[0])? $params[0]:0;
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];	
		$last_id=maxId($db,"{$dbg}.01_courses");
		$major_id=$post['major_id'];
		unset($post['major_id']);	
		$crid_array=getCridArray($db,$dbg,$major_id);
		foreach($crid_array AS $crid){
			$post['crid']=&$crid;
			$db->add("{$dbg}.01_courses",$post);						
		}	/* foreach */
				
		$q="UPDATE {$dbg}.01_courses AS crs
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
			INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id			
			SET crs.name=CONCAT(cr.code,'-',sub.code) WHERE crs.id>'$last_id';";	
		$sth=$db->query($q);
		$msg="Courses added.";
		flashRedirect("uniclassrooms",$msg);			
		exit;		
	}	/* post */	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects']=fetchRows($db,"{$dbo}.`05_subjects`"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	
	if(!isset($_SESSION['majors'])){ $_SESSION['majors']=fetchRows($db,"{$dbg}.`05_majors`","id,code,name"); } 
	$data['majors']=$_SESSION['majors'];	
	
	// $data['uniclassrooms']=$_SESSION['uniclassrooms'];			
	// $this->view->render($data,"unicourses/addUnicourse");
	$this->view->render($data,"unicourses/createUnicourses");
	
}	/* fxn */


public function getCridArray($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/unicoursesFxn.php');
	$major_id=isset($params[0])? $params[0]:1;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$ca=getCridArray($db,$dbg,$major_id);
	pr($ca);			
}	/* fxn */

public function getCrsArray($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/unicoursesFxn.php');
	$major_id=isset($params[0])? $params[0]:1;
	$subject_id=isset($params[1])? $params[1]:10;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$ca=getCrsArray($db,$dbg,$major_id,$subject_id);
	pr($ca);			
}	/* fxn */


public function juxtapose($params=NULL){
$dbo=PDBO;
	$data['major_id']=$major_id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	/* 1 */
	$q="SELECT sxn.id,sxn.code,sxn.name,cr.id AS crid,cr.name AS classroom FROM {$dbg}.01_classrooms AS cr
		INNER JOIN {$dbg}.01_sections AS sxn ON cr.section_id=sxn.id WHERE cr.major_id='$major_id'; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sections=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	/* 2 */
	$data['major']=fetchRow($db,"{$dbg}.`05_majors`",$major_id);
	
	$courses=array();
	for($i=0;$i<$count;$i++){
		$sxn=$sections[$i]['id'];
		$q="SELECT crs.id AS crs,crs.code AS crscode,crs.name AS course
			FROM {$dbg}.01_courses AS crs
			INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
			WHERE cr.major_id='$major_id' AND cr.section_id='$sxn';";
		$sth=$db->querysoc($q);
		$courses[$i]=$sth->fetchAll();		
	}	/* foreach */
	
	$data['courses']=&$courses;
	
	if(!isset($_SESSION['majors'])){ $_SESSION['majors']=fetchRows($db,"{$dbg}.`05_majors`","id,code,name"); } 
	$data['majors']=$_SESSION['majors'];

	
	$this->view->render($data,"unicourses/juxtaposeUnicourses");
	
}	/* fxn */



public function view($params=NULL){	
$dbo=PDBO;
	$data['crs']=$crs=isset($params[0])? $params[0]:false;
	if(!$crs){ pr("Course ID Not set."); exit; }
	$data['db']=$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	
	$q="SELECT crs.* FROM {$dbg}.01_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		WHERE crs.id='$crs' LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();	
	
	$vfile="unicourses/viewUnicourse";
	$this->view->render($data,$vfile);	
	
}	/* fxn */



}	/* BlankController */
