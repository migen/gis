<?php

Class CoursesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->dbtable=PDBG.".05_courses";
	
	$acl = array(array(5,0),array(4,0),array(9,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function index(){
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=&$dbg;
	$data['rows'] = fetchRows($db,"{$dbo}.`05_levels`",'id,code,name','id');
	$data['count'] = count($data['rows']);
	$this->view->render($data,'courses/index');
}	/* fxn */

public function settings($params=NULL){
$data['lvl'] = $lvl=isset($params[0])?$params[0]:4;
require_once(SITE.'functions/subjects.php');
require_once(SITE.'functions/levels.php');
require_once(SITE.'functions/courses.php');
require_once(SITE.'functions/components.php');
require_once(SITE.'functions/classrooms.php');
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",'id,code,name','id');
$where=" AND cr.section_id <> 1 AND section_id <> 2 ";
$data['classrooms'] = $classrooms = getClassroomsByLevel($db,$lvl,$dbg,$where);
$data['num_classrooms'] = $num_classrooms = count($classrooms);

$data['level'] = getLevel($db,$lvl,$dbg);

$subjects = (isset($_GET['get']))? getSubjects($db,$dbg):getLevelSubjects($db,$dbg,$lvl);
$data['subjects'] = $subjects;	
$data['num_subjects'] = $num_subjects = count($subjects);	

for($y=0;$y<$num_subjects;$y++){
	/* 2 */	
	$sub=$subjects[$y]['sub'];
	$components[$y] = getCourseComponents($db,$lvl,$sub,$dbo,$dbg); // coursesFxn
}	/* components */

for($x=0;$x<$num_classrooms;$x++){
	$courses[$x]=array();
	for($y=0;$y<$num_subjects;$y++){
		/* 1 */
		$sub=$subjects[$y]['sub'];
		$crid=$classrooms[$x]['id'];
		$courses[$x][$y] = getCourseBySubject($db,$sub,$crid,$dbo,$dbg);
	}	/* subjects loop */		
}	/* classrooms loop */

$data['courses'] = isset($courses)? $courses:NULL;
$data['components'] = isset($components)? $components:NULL;

$this->view->render($data,'courses/settings');

}	/* fxn */

public function teachers(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;
$data['get'] = $get = isset($_GET)? $_GET:false;
$cond="";
$lvl=(isset($get['lvl']))? $get['lvl'] :4;
$lvl = (isset($get['crid']) && ($get['crid']>0))? 0:$lvl;
$data['lvl'] = $get['lvl'] = $lvl;
$cond .= (isset($get['crid']) && ($get['crid']>0))? " AND crs.crid=".$get['crid']:NULL;

$lvl = (isset($get['all']))? 0:$lvl;
$cond .= ($lvl>0)? " AND cr.level_id=".$get['lvl']:NULL;
$data['order'] = $order = isset($_GET['order'])? $_GET['order'] : 'ASC';
$data['sort'] = $sort = isset($_GET['sort'])? $_GET['sort'] : 'l.id,sxn.name,sub.name';




$q="
SELECT 
	crs.id AS crs,crs.name AS course,crs.tcid,
	c.name AS teacher,cr.name AS classroom,cr.section_id AS sxn,
	l.name AS level,sxn.name AS section,sub.name AS subject
FROM {$dbg}.05_courses AS crs
	LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
	LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
	LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
WHERE 1=1 $cond
	
";
$q .= " ORDER by $sort $order; ";

// pr($q);
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id");

$this->view->render($data,'courses/teachers');


}	/* fxn */

public function edit($params){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/contactsFxn.php");
	$dbo=PDBO;$db =& $this->model->db;

	$data['course_id']	= $course_id 	 = $params[0];
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;	
	$dbg=VCPREFIX.$sy.US.DBG;

	$_SESSION['url']="courses/edit/$course_id";
		
	if(isset($_POST['submit'])){
		$row = $_POST['course'];
		// pr($row);exit;
		$db->update("{$dbg}.05_courses",$row,"id='$course_id'");						
		$url="courses/edit/$course_id";
		redirect($url,"Course saved.");
		exit;
	}	/* post */

/* ------------------------ process ---------------------------------------- */

	// $data['row']=getCourseDetails($db,$course_id,$dbg);	
	
	$q="SELECT crs.*,sub.name AS subject,c.name AS teacher 
		FROM {$dbg}.05_courses AS crs 
		LEFT JOIN {$dbo}.05_subjects AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbo}.00_contacts AS c ON crs.tcid=c.id
		WHERE crs.id=$course_id LIMIT 1; ";
	$sth=$db->query($q);
	$data['row']=$sth->fetch();
	
	
	if(!isset($_SESSION['crstypes'])){ $_SESSION['crstypes']=fetchRows($db,"{$dbo}.05_crstypes","id,code,name","name"); } 
	$data['crstypes']=$_SESSION['crstypes'];
	if(!isset($_SESSION['subjects'])){ $_SESSION['subjects']=fetchRows($db,"{$dbo}.05_subjects","id,code,name","name"); } 
	$data['subjects']=$_SESSION['subjects'];
	$data['classrooms']=$_SESSION['classrooms'];


	/* 3 */
	$schema=$dbg;$table="05_courses";	
	sessionizeColumnsOfDbtable($db,$dbg,$table,"courses",$except="'id'");
	$data['cols']=$_SESSION['cols']['courses'];


	$this->view->render($data,'courses/editCourses');

}	/* fxn */

public function delete($params){
	$course_id = $params[0];
	require_once(SITE."functions/setup.php");
	$db =& $this->model->db;
	delcrs($db,$course_id);
	$url = $_SESSION['url'];
	redirect($url);
	exit;

}	/* fxn */


public function config($params=NULL){
$acl = array(array(5,0));
$this->permit($acl);				

$data['lvl'] = $lvl=isset($params[0])?$params[0]:4;
require_once(SITE.'functions/levels.php');
require_once(SITE.'functions/subjects.php');
require_once(SITE.'functions/classrooms.php');
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",'id,code,name','id');

$data['level'] = getLevel($db,$lvl,$dbg);
$subjects = (isset($_GET['get']))? getSubjects($db,$dbg):getLevelCourses($db,$dbg,$lvl);
$q=$_SESSION['q'];
$data['q']=$q;
$data['subjects'] = $subjects;
$data['count'] = count($subjects);


if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$lvls=isset($_POST['levels'])? $_POST['levels']:array($lvl);
	$q="";
	foreach($posts AS $post){
		if(isset($post['is_checked'])){
			foreach($lvls AS $lvl){
				$q.=propagateLevelCoursesQuery($lvl,$post);			
			}
		}
	}
	// pr($q);exit;	
	$db->query($q);
	$url="courses/settings/$lvl";
	$msg="Level $lvl Courses Updated.";
	flashRedirect($url,$msg);
	exit;
}

if(isset($_POST['purge'])){
	require_once(SITE.'functions/purge.php');
	$posts = $_POST['posts'];
	$lvls=isset($_POST['levels'])? $_POST['levels']:array($lvl);
	$q="";
	foreach($posts AS $post){
		if(isset($post['is_checked'])){
			foreach($lvls AS $lvl){				
				$sub=$post['subject_id'];
				$q.=purgeLevelCoursesQuery($lvl,$sub);			
			}
		}
	}
	$db->query($q);
	$url="courses/settings/$lvl";
	$msg="Level $lvl Courses Purged.";
	flashRedirect($url,$msg);
	exit;
}	/* purge level courses */



if(isset($_GET['subjects'])){
	$data['allsubjects'] = fetchRows($db,"{$dbo}.`05_subjects`",'id,code,name',$order='name');
}

if(isset($_POST['create'])){
	$subs_str=$_POST['subs'];
	$subs_arr = array_filter(explode(',',$subs_str));	
	$subs_arr = rally('trim',$subs_arr);	
	$where=" AND cr.section_id <> 1 AND section_id <> 2 ";
	$classrooms = getClassroomsByLevel($db,$lvl,$dbg,$where);
	$crids=buildArray($classrooms,'crid');
	$q="";
	foreach($subs_arr AS $sub){ 
		$q.=createLevelCoursesQuery($crids,$sub);
	}
	// pr($q); exit;
	$db->query($q);
	$url="syncs/syncCQ/dashboard";
	$msg="Courses Created. Please Setup Courses.";
	flashRedirect($url,$msg);
	exit;


}	/* fxn */

$_SESSION['url']="courses/config/$lvl";
$this->view->render($data,'courses/configCourses');

}	/* fxn */


public function set(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;			
	$q="SELECT crs.id AS crs,crs.name AS course,crs.label AS course_label,l.code AS lvlcode,s.code AS sxncode,
			crs.crid,cr.level_id AS lvl,cr.section_id AS sxn,l.name AS level,s.name AS section,
			crs.tcid,c.name AS teacher,crs.is_active,sub.code AS subcode,sub.name AS subject,sub.id AS subid
		FROM {$dbg}.05_courses AS crs 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid	
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id	
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id	
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sub.id=crs.subject_id	
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=crs.tcid	
		ORDER BY cr.level_id,cr.section_id,sub.name; ";
	debug($q,"Courses All");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'courses/setCourses');
}	/* fxn */



public function filter($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	$this->view->render($data,"courses/filterCourse");	
	
}	/* fxn */


public function one($params){
	$data['crs']=$crs=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT crs.id AS crs,crs.name AS course,crs.label,crs.subject_id,cr.level_id,cr.section_id,
			l.name AS level,s.name AS section,sub.name AS subject,
			cq.*
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON crs.id=cq.course_id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		WHERE crs.id=$crs LIMIT 1;				
	";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
		
	$this->view->render($data,"courses/oneCourse");	
	
	
}	/* fxn */



public function positions(){
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['get'] = $get = isset($_GET)? $_GET:false;
$cond="";
$lvl=(isset($get['lvl']))? $get['lvl'] :4;
$lvl = (isset($get['crid']) && ($get['crid']>0))? 0:$lvl;
$data['lvl'] = $get['lvl'] = $lvl;
$cond .= (isset($get['crid']) && ($get['crid']>0))? " AND crs.crid=".$get['crid']:NULL;

$lvl = (isset($get['all']))? 0:$lvl;
$cond .= ($lvl>0)? " AND cr.level_id=".$get['lvl']:NULL;
$data['order'] = $order = isset($_GET['order'])? $_GET['order'] : 'ASC';
$data['sort'] = $sort = isset($_GET['sort'])? $_GET['sort'] : 'sub.name';

$q="SELECT 
	crs.id AS crs,crs.name AS course,crs.tcid,
	c.name AS teacher,cr.name AS classroom,cr.section_id AS sxn,
	l.name AS level,sxn.name AS section,sub.name AS subject,crs.position
FROM {$dbg}.05_courses AS crs
	LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
	LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
	LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
WHERE 1=1 $cond	";
$q .= " ORDER by $sort $order; ";

// pr($q);
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id");

$this->view->render($data,'courses/positionsCourses');


}	/* fxn */


public function byClassroom($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:1;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="
		SELECT
			cr.name AS classroom,crs.name AS course,subj.name AS subject,
			cr.id AS crid,crs.id AS course_id,cr.level_id,cr.section_id,
			crs.subject_id,crs.semester,crs.label AS course_label,
			subj.label AS subject_label,subj.subjtype_id,
			teac.name AS teacher,crs.tcid		
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
		INNER JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		INNER JOIN {$dbo}.05_subjects AS subj ON crs.subject_id=subj.id
		LEFT JOIN {$dbo}.00_contacts AS teac ON crs.tcid=teac.id
		WHERE cr.id=$crid
		ORDER BY crs.semester,crs.name;
		
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$q="SELECT id,name,level_id FROM {$dbg}.05_classrooms WHERE id=$crid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();
	
	$this->view->render($data,"courses/byclassroomCourses");
	
	
}	/* fxn */


public function byLevel($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="
		SELECT
			cr.name AS classroom,crs.name AS course,subj.name AS subject,
			cr.id AS crid,crs.id AS course_id,cr.level_id,cr.section_id,
			crs.subject_id,crs.semester,crs.crid,
			subj.subjtype_id,
			teac.name AS teacher,crs.tcid		
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
		INNER JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		INNER JOIN {$dbo}.05_subjects AS subj ON crs.subject_id=subj.id
		LEFT JOIN {$dbo}.00_contacts AS teac ON crs.tcid=teac.id
		WHERE cr.level_id=$lvl
		ORDER BY cr.id,crs.semester,crs.name;		
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$q="SELECT id,name FROM {$dbo}.05_levels WHERE id=$lvl LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['lvl']=$sth->fetch();
	
	$this->view->render($data,"courses/bylevelCourses");
	
	
}	/* fxn */





}	/* CoursesController */
