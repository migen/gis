<?php

Class GsetController extends Controller{	

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
	$data['sy']=DBYR;$data['qtr']=$_SESSION['qtr'];
	$vfile='gset/indexGset';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */

public function renameClassrooms($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/gsetFxn.php');
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	$q=renameClassrooms($db,$sy);
	pr($q);
	echo "&exe to process<br />";
	if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "Success.":"Failed."; }
	// flashRedirect('gset/classrooms','All Classrooms renamed.');
}	/* fxn */


public function renameCourses($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/gsetFxn.php');
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	$q=renameCourses($db,$sy);
	pr($q);
	echo "&exe to process<br />";
	if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "Success.":"Failed."; }
	// flashRedirect('gset/classrooms','All Classrooms renamed.');
}	/* fxn */


public function sections(){ 	
	$dbo=PDBO;
	require_once(SITE.'functions/gsetFxn.php');
	$db=&$this->model->db;$dbg=PDBG;	
	if(isset($_POST['submit'])){
		sudo();	
		$posts=$_POST['posts'];
		$q="";		
		foreach($posts AS $post){
			$lvlr=explode(",",$post['lvls']);$sxn=$post['section_id'];
			foreach($lvlr AS $lvl){ $q.=insertClassroomIfNotExists($db,$dbg,$lvl,$sxn); }
		}
		$sth=$db->query($q);
		/* 2 */
		renameClassrooms($db);
		$msg=($sth)? "Added successfully.":"Adding classrooms failed.";
		flashRedirect('gset/sections',$msg);		
		exit;
	}	/* post */	
	$order=isset($_GET['order'])? $_GET['order']:"id";
	$rows=fetchRows($db,"{$dbo}.`05_sections`","*",$order);
	$data['rows']=&$rows;
	$data['count']=count($rows);	
	$records=array();
	$brid=isset($_GET['brid'])? $_GET['brid']:$_SESSION['brid'];
	$cond=isset($_GET['all'])? NULL:" AND cr.branch_id=$brid ";
	foreach($rows AS $row){
		$q="SELECT cr.id AS crid,l.name AS level,l.id AS lvl FROM {$dbg}.`05_classrooms` AS cr
			LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id WHERE cr.`section_id`='".$row['id']."' $cond ORDER BY l.id; ";
		$sth=$db->querysoc($q);
		$records[]=$sth->fetchAll();
	}
	debug($q);
	renameClassrooms($db);
	$data['records']=&$records;		
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");	
	$this->view->render($data,'gset/sectionsGset');
	
}	/* fxn */

public function students(){ 
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$sort=isset($_GET['sort'])? $_GET['sort']:"name";
	$q="SELECT id,parent_id AS pcid,code,name FROM {$dbo}.`00_contacts` WHERE `role_id`='".RSTUD."' ORDER BY `$sort`;";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);	
	$this->view->render($data,'gset/studentsGset');

}	/* fxn */

public function setupStudents(){
	sudo();	
	require_once(SITE."functions/contactsFxn.php");
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];		
		$pass=MD5('pass');		
		foreach($posts AS $post){
			// pr($post);
			$name=trim($post['name']);$post['begsy']=DBYR;$post['sy']=DBYR;$post['parent_id']=$post['id'];
			$post['pass']=&$pass;$post['account']=&$post['code'];$post['privilege_id']=1;
			if(!empty($name)){ 
				$code=$post['code'];					
				$exists=validateCode($db,$code,$dbg);
				if(!$exists){ $db->add("{$dbo}.`00_contacts`",$post); }				
			}	/* name */	
				
		}
 		require_once(SITE.'functions/syncTables.php');
		syncTable($db,"{$dbg}.`05_summaries`",$field="scid");	/* summ */
		if(isset($_SESSION['settings']['has_college']) AND ($_SESSION['settings']['has_college']==1)){
			syncTableCollege($db,"{$dbg}.`01_summaries`",$field="scid");	/* summaries_college */
		}
			
		// if(isset($_POST['axis'])){ syncTable($db,"{$dbg}.`03_tsummaries`",$field="scid"); }	/* test */		
		flashRedirect('gset/students','Setup added students.');		
		exit;
	}
	$data=NULL;
	$q="SELECT id,code,name FROM {$dbo}.`00_contacts` ORDER BY id DESC LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['last_contact']=$sth->fetch();
	
	$this->view->render($data,'gset/setupStudentsGset');

}	/* fxn */

public function teachers(){ 	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$order=isset($_GET['order'])? $_GET['order']:"c.name";
	$q="SELECT c.id,c.parent_id AS prid,c.code,c.name,c.account,p.ctp,c.is_active 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_ctp` AS p ON p.contact_id=c.id
		WHERE c.`role_id`='".RTEAC."' ORDER BY $order;";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);	
	$this->view->render($data,'gset/teachersGset');

}	/* fxn */

public function setupTeachers(){
	sudo();	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;		
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$pass=MD5('pass');
		foreach($posts AS $post){
			$name=trim($post['name']);$code=trim($post['code']);
			if(!empty($name)){ 
				$q="SELECT id FROM {$dbo}.`00_contacts` WHERE code='$code' LIMIT 1; ";
				$sth=$db->querysoc($q);
				$row=$sth->fetch();
				if(!$row){
					$post['sy']=DBYR;$post['begsy']=DBYR;$post['pass']=&$pass;		
					$post['parent_id']=$post['id'];$post['account']=$post['code'];
					$post['role_id']=RTEAC;$post['privilege_id']=1;$post['title_id']=14;
					$db->add("{$dbo}.`00_contacts`",$post); 					
				}
			}							
		}	/* foreach */
		require_once(SITE.'functions/syncTables.php');
		syncTable($db,"{$dbo}.`00_ctp`",$field="contact_id");	/* ctp */
		flashRedirect('gset/teachers','Setup added teachers.');				
		exit;
	}
	$data=NULL;
	$this->view->render($data,'gset/setupTeachersGset');

}	/* fxn */

public function levels(){ 
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$data['count']=count($data['rows']);
	$vfile="gset/levelsGset";vfile($vfile);
	$this->view->render($data,$vfile,'bootstrap');	
}	/* fxn */

public function classrooms(){ 
	require_once(SITE.'functions/classrooms.php');
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$order=isset($_GET['order'])? $_GET['order']:"cr.branch_id,cr.level_id";
	$brid=isset($_GET['brid'])? $_GET['brid']:$_SESSION['brid'];
	$cond_brid=isset($_GET['all'])? NULL:"AND cr.branch_id=$brid";
	$cond_sxn=isset($_GET['sxn'])? "AND cr.section_id=".$_GET['sxn']:"AND cr.section_id > 2";

	$q="SELECT cr.id AS crid,cr.code,cr.name,cr.level_id,cr.section_id,cr.acid,cr.branch_id AS brid,
			cr.num,cr.major_id,
			c.name AS adviser,l.name AS level,l.code AS lvlcode,s.name AS section,s.code AS sxncode,cr.is_active
		FROM {$dbg}.`05_classrooms` AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id
		LEFT JOIN {$dbo}.`05_sections` AS s ON s.id=cr.section_id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=cr.acid
		WHERE 1=1 $cond_sxn $cond_brid ORDER BY $order;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=count($data['rows']);	
	$vfile="gset/classroomsGset";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */

public function setupSections(){
	sudo();	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$order=isset($_GET['order'])? $_GET['order']:"name";
	if(isset($_POST['add'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){ 
			$q="SELECT id FROM {$dbo}.`05_sections` WHERE `code`='".$post['code']."' OR `name`='".$post['name']."' LIMIT 1; ";
			$sth=$db->querysoc($q);
			$row=$sth->fetch();
			if(!$row){ $db->add("{$dbo}.`05_sections`",$post); }				
		}
		flashRedirect("gset/sections","Batch sections added.");
		exit;		
	}	/* post */
	
	$data['rows']=fetchRows($db,"{$dbo}.`05_sections`","*",$order);
	$data['count']=count($data['rows']);
	$this->view->render($data,'gset/setupSectionsGset');

}	/* fxn */

public function subjects(){ 
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$order=isset($_GET['order'])? $_GET['order']:"name";
	$data['rows']=fetchRows($db,"{$dbo}.`05_subjects`","id,code,name",$order);
	$data['count']=count($data['rows']);	
	$this->view->render($data,'gset/subjectsGset');
}	/* fxn */

public function setupSubjects(){
	sudo();	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$order=isset($_GET['order'])? $_GET['order']:"name";
	if(isset($_POST['add'])){	
		$posts=$_POST['posts'];
		foreach($posts AS $post){ 
			$code=addSlashes($post['code']);$name=addSlashes($post['name']);
			$q="SELECT id FROM {$dbo}.`05_subjects` WHERE `code`='$code' OR `name`='$name' LIMIT 1; ";
			$sth=$db->querysoc($q);
			$row=$sth->fetch();
			if(!$row){ $db->add("{$dbo}.`05_subjects`",$post); }		
		}
		flashRedirect("gset/subjects","Subjects added.");
		exit;		
	}	/* post */
	
	$data['rows']=fetchRows($db,"{$dbo}.`05_subjects`","*",$order);
	$data['count']=count($data['rows']);
	$this->view->render($data,'gset/setupSubjectsGset');

}	/* fxn */


public function criteria(){ 	
	require_once(SITE.'functions/gsetFxn.php');
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	if(isset($_POST['add'])){
		sudo();	
		$posts=$_POST['posts'];
		$q="";		
		foreach($posts AS $post){		
			$code=trim($post['code']);$name=trim($post['name']);
			if((!empty($name)) && (!empty($name))){
				$q="SELECT id FROM {$dbo}.`05_criteria` WHERE `code`='".$post['code']."' OR `name`='".$post['name']."' LIMIT 1; ";
				$sth=$db->querysoc($q);
				$row=$sth->fetch();
				if(!$row){ $db->add("{$dbo}.`05_criteria`",$post); }					
			}
		}
		flashRedirect('gset/criteria',$msg);		
		exit;
	}	/* post */	
	$order=isset($_GET['order'])? $_GET['order']:"position";
	$where=isset($_GET['ctype'])? " WHERE crstype_id='".$_GET['ctype']."'":NULL;
	$data['rows']=fetchRows($db,"{$dbo}.`05_criteria`","*",$order,$where);
	$data['count']=count($data['rows']);	

	$vfile='gset/criteriaGset';vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function crs($params=NULL){
	$level_id = isset($params[0])? $params[0]:4;
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	if(isset($_GET['all'])){ $level_id = false; }
	$data['level_id'] = $level_id;		
	if(isset($_POST['batch'])){
		$url="mis/delcrs/";
		foreach($_POST['rows'] AS $id){ $url.=$id.'/'; }
		flashRedirect($url,'Batch courses deleted.');exit;		
	}	/* batch */

	if(isset($_POST['save'])){
		$posts = $_POST['posts'];
		$q="";
		foreach($posts AS $post){
			if($post['tcid']>0){		
				$tcid=$post['tcid'];
				$q.="UPDATE {$dbg}.05_courses SET `tcid`= '$tcid' WHERE `id` = '".$post['crsid']."' LIMIT 1;";
			}
		}
		$db->query($q);
		$url="setup/loading/$level_id";
		flashRedirect($url,'Teachers assigned.');exit;
	}	/* save */
	
	$q = " SELECT crs.*,crs.id AS crsid,crs.name AS course,c.name AS teacher,
			crs.tcid AS tcid,cr.name AS classroom,crs.label AS subject 
			FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id ";
	if($level_id){ 
		$q .=" WHERE cr.level_id = '$level_id'";
		$data['level'] = fetchRow($db,"{$dbo}.`05_levels`",$level_id);
	}	
	$q .= "	ORDER BY cr.level_id,section_id; ";
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['levels'] = $_SESSION['levels'];
	$where="WHERE `role_id`='".RTEAC."' ";
	$data['teachers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,parent_id,name','name',$where);
	
	$vfile='gset/crsGset';vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */



public function setupClubs(){
	sudo();	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$order=isset($_GET['order'])? $_GET['order']:"name";
	if(isset($_POST['add'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){ 
			$q="SELECT id FROM {$dbg}.05_clubs WHERE `code`='".$post['code']."' OR `name`='".$post['name']."' LIMIT 1; ";
			$sth=$db->querysoc($q);
			$row=$sth->fetch();
			if(!$row){ $db->add("{$dbg}.05_clubs",$post); }
		}
		flashRedirect("gset/clubs","Batch clubs	 added.");
		exit;		
	}	/* post */
	
	$data['rows']=fetchRows($db,"{$dbg}.`05_clubs`","*",$order);
	$data['count']=count($data['rows']);
	$this->view->render($data,'gset/setupClubsGset');

}	/* fxn */

public function clubs(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$q="SELECT cl.*,c.name AS teacher FROM {$dbg}.05_clubs AS cl LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=cl.tcid; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=count($data['rows']);
	$this->view->render($data,'gset/clubsGset');
}	/* fxn */


public function syncboard(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;	
	$acl=array(array(5,0));$this->permit($acl);	
	$data['qtr']=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	
	$this->view->render($data,'gset/syncboardGset');

}	/* fxn */


public function truncateDummies(){
	$dbo=PDBO;$dbg=PDBG;
	$q="";
	$q.="DELETE FROM {$dbo}.`00_contacts` WHERE `id`>300; ";
	$q.="DELETE FROM {$dbg}.05_summaries WHERE `scid`>300; ";
	$q.="TRUNCATE {$dbg}.05_attendance; ";$q.="TRUNCATE {$dbg}.50_activities; ";
	$q.="TRUNCATE {$dbg}.50_grades; ";$q.="TRUNCATE {$dbg}.50_scores; ";
	pr($q);
	echo "<a href='".URL."mis/query' >MIS Query</a>";


}	/* fxn */

public function initClassrooms($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	require_once(SITE."functions/gsetFxn.php");
	$db=$this->baseModel->db;
	initClassrooms($db,$sy);
	
}	/* fxn */


public function courses($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/classrooms.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/setup.php");
$db =& $this->model->db;

$data['lid'] = $lid = isset($params[0])? $params[0] : 4;
$data['ssy'] = $ssy = $_SESSION['sy'];
$data['sy'] = $sy 	= isset($params[1])? $params[1] : DBYR;
$data['brid']=$brid=$_SESSION['brid'];

if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
$data['branches']=$_SESSION['branches'];	

$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

$q   = " SELECT * FROM {$dbo}.`05_levels` WHERE `id` = '$lid' LIMIT 1; ";
$sth = $db->querysoc($q); 
$data['level']	= $level = $sth->fetch();

if(isset($_POST['create'])){
	$classroom_string = $_POST['classroom_string'];
	$classroom_array = explode(',',$classroom_string);	
	
	$subject_string = $_POST['subject_string'];
	$subject_array = explode(',',$subject_string);
		
	foreach($classroom_array AS $crid){
	
		foreach($subject_array AS $subid){
			$q = "SELECT id FROM {$dbg}.05_courses WHERE `subject_id` = '$subid' AND `crid` = '$crid' LIMIT 1; ";
			$sth = $db->querysoc($q);
			$row = $sth->fetch();
			$has_subject = ($row)? true : false;			
			$classroom 	 = $this->model->fetchRow("{$dbg}.05_classrooms",$crid);
			if(!$has_subject){ 
				$q = "SELECT * FROM {$dbo}.`05_subjects` WHERE `id` = $subid LIMIT 1; ";			
				$sth = $db->query($q);
				$subject = $sth->fetch();
				$ctype 		= $subject['crstype_id'];
				$position 	= $subject['position'];
				$code 		= $subject['code'];
				$name 		= $subject['name'];
				setupCourse($db,$crid,$subid,$ctype,$position,$code,$name); 										
			}		
		}
	}
	$url = "gset/courses/$lid";
	$_SESSION['message'] = 'Courses created!';
	redirect($url);
	exit;

}	/* post-create */


if(isset($_POST['delete'])){
	$courses_string = $_POST['courses_string'];
	$courses_array = explode(',',$courses_string);	
	foreach($courses_array AS $crsid){
		delcrs($db,$crsid);
	}	
	$url = "gset/courses/$lid";
	$_SESSION['message'] = 'Courses Purged!';
	redirect($url);
	exit;

}	/* post-delete */



$q="SELECT cr.id AS `crid`, cr.name ,sxn.code AS section_code,sxn.name AS section,cr.name AS cr,cr.label AS crlabel
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_sections` AS sxn ON sxn.id = cr.section_id
	WHERE cr.branch_id=$brid AND cr.`level_id` = '$lid' ORDER BY cr.`section_id` DESC ; ";
debug("DataController-courses: ".$q);
$sth=$this->baseModel->db->querysoc($q);
$data['classrooms']=$classrooms=$sth->fetchAll();
$data['numrows']=$numrows=count($classrooms);

for($i=0;$i<$numrows;$i++){
	$crid = $classrooms[$i]['crid'];
	$order = "subject_id";	
	$courses[$i] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$data['numcourses'][$i] = count($courses[$i]);

}

$data['courses'] =& $courses;
$data['subjects'] = $this->model->fetchRows("{$dbo}.`05_subjects`",'id,code,name','name');
$data['levels']   = $this->model->fetchRows("{$dbo}.`05_levels`",'id,code,name','id');
$data['numsub'] = count($data['subjects']);

$fields="id,code,name,level_id,section_id";
$where="AND section_id>2";
$order="level_id,section_id";
$data['allClassrooms']=getAllClassrooms($db,$dbg,$fields,$where,$order);

// $view = isset($_GET['detailed'])? 'courses_detailed':'coursesData';
$view = isset($_GET['detailed'])? 'coursesDetailed':'coursesGset';
vfile($view);
$this->view->render($data,"gset/$view");

}	/* fxn */




public function components($params=NULL){
	$dbo=PDBO;
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classrooms.php");
	require_once(SITE."functions/components.php");
	
	$data['level_id'] = $level_id = isset($params[0])? $params[0]:4;	
	$_SESSION['level_id']	= $level_id;
	$sy=isset($params[1])? $params[1]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db =& $this->model->db;
	$_SESSION['url']="gset/components/$level_id";
	if(!isset($_SESSION['levels'])){ 
		$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,name","id"); 	 } 
		
	/* for batch edits */
	if(isset($_POST['batch'])){
		// pr($_POST);
		$ids = stringify($_POST['rows']);		
		$url = 'components/edit/'.$ids;
		redirect($url);		
	}
		
	$data['level'] 	= getLevelDetails($db,$level_id,$dbg);
	$_SESSION['components']['level_id'] = $level_id;
	$rdata  = getComponentsByLevel($db,$level_id,$dbg);	
	$data['q']  = $rdata['q'];
	$data['components']=$rdata['components'];	
	$data['classrooms']=getClassroomsByLevel($db,$level_id,$dbg); 
	$data['levels'] = $_SESSION['levels'];
	$this->view->render($data,'gset/componentsGset');

}	/* fxn */


	
public function critypes(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbo}.`05_critypes` SET name='".$post['name']."' WHERE id='".$post['id']."' LIMIT 1; ";
		}
		$db->query($q);
		flashRedirect("critypes",'Critypes saved.');
		exit;		
		
	}	/* post */	
	$q="SELECT *,id AS id FROM {$dbo}.`05_critypes` ORDER BY id;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['rows']=$sth->rowCount();

	$this->view->render($data,'gset/critypesGset');
}	/* fxn */




}	/* BlankController */
