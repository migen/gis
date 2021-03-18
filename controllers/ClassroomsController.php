<?php

Class ClassroomsController extends Controller{	

private $dbtable;

public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBG.".05_classrooms";	
	$this->beforeFilter();
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data=NULL;
	$this->view->render($data,"classrooms/indexClassrooms");

}	/* fxn */



/* view should be in teachers folder */
public function courses($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/reports.php");
$data['crid']=$crid= isset($params[0])? $params[0] : '1';
$data['ssy']=$ssy=DBYR;
$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
$_SESSION['url'] = "classrooms/courses/$crid/$sy";
$_SESSION['courses']['crid'] = $crid;
$db =& $this->model->db;	
$dbg=VCPREFIX.$sy.US.DBG;	

$data['home']=$home=$_SESSION['home'];
$data['user']=$user=$_SESSION['user'];
	
	if(isset($_POST['submit'])){
		$courses = $_POST['courses'];
		$q = "";
		foreach($courses AS $row){
			$q .= " UPDATE {$dbg}.05_courses SET `code`   	= '".$row['code']."',`label`  	= '".$row['label']."',
					`subject_id` = '".$row['subject_id']."',`supsubject_id` = '".$row['supsubject_id']."',
					`tcid` = '".$row['tcid']."',`crstype_id` = '".$row['crstype_id']."',
					`is_active` = '".$row['is_active']."',`with_scores`  = '".$row['with_scores']."',
					`is_displayed` = '".$row['is_displayed']."',
					`in_genave`    = '".$row['in_genave']."',`affects_ranking` = '".$row['affects_ranking']."',
					`is_aggregate` = '".$row['is_aggregate']."',`is_transmuted` = '".$row['is_transmuted']."',`course_weight`  = '".$row['course_weight']."',`position`  = '".$row['position']."',
					`indent`  	= '".$row['indent']."',`semester`  = '".$row['semester']."',
					`is_num`  = '".$row['is_num']."',`schedule`  = '".$row['schedule']."'
					WHERE `id` = '".$row['id']."';
			";
		}
		$this->model->db->query($q);
		$url = "classrooms/courses/$crid";
		redirect($url);		
	
	}	/* post */
	
/* --------------------------- process --------------------------- */

	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	$_SESSION['course']['level_id'] = $data['classroom']['level_id'];
	$order = "crs.semester,crs.crstype_id,crs.position,crs.id";
	$data['courses'] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$q=isset($_SESSION['q'])? $_SESSION['q']:NULL;
	$data['q']=$q;
	$data['num_courses'] = count($data['courses']);
	$data['subjects'] 		= fetchRows($db,"{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');
	$data['crstypes'] 	= fetchRows($db,"{$dbo}.`05_crstypes`");
	$_SESSION['courses']['crid'] = $crid;
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
	
	$adroles=array(RMIS,RACAD,RREG);
	$srid=$_SESSION['srid'];
	$data['admin']=$admin=in_array($srid,$adroles)? true:false;
	$editable=($admin || ($_SESSION['settings']['advcrs_setup']==1))? true:false;
	$data['editable']=$editable;
	
	$vfile='classrooms/coursesClassrooms';vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */



public function advisers(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT
			cr.id AS crid,cr.*,c.name AS adviser,l.name AS level,s.name AS section,c.account AS login
		FROM {$dbg}.05_classrooms AS cr 
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		WHERE cr.section_id>3
		ORDER BY cr.level_id,cr.id; ";
	$sth=$db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$this->view->render($data,'classrooms/advisers');


}	/* fxn */



public function roster($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;$dbg=PDBG;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['sy'] = DBYR; 
$data['classroom'] = getClassroomDetails($db,$crid);
$lvlid = $data['classroom']['level_id'];
$data['home'] = $home = $_SESSION['home'];

$srid=$_SESSION['srid'];
$is_admin=($srid!=RTEAC)? true:false;
$is_advi=(($srid==RTEAC) && (in_array($crid,$_SESSION['teacher']['advisory_ids'])))? true:false;
if($is_admin || $is_advi){ } else { flashRedirect($home); }

$q = "SELECT id AS tmpcrid FROM {$dbg}.05_classrooms WHERE `level_id` = '$lvlid' AND `section_id` = '1' LIMIT 1;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$data['tmpcrid'] = $row['tmpcrid'];

$q = "SELECT cr.id AS outcrid FROM {$dbg}.05_classrooms AS cr 
LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id
WHERE cr.`level_id` = '$lvlid' AND s.`code` = 'OUT' LIMIT 1;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$data['outcrid'] = $row['outcrid'];

if($crid){
	$q = "
		SELECT 
			c.id AS scid,c.code,c.name AS student,c.position,c.is_active
		FROM {$dbo}.`00_contacts` AS c 		
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		WHERE summ.crid = '$crid' ORDER BY c.name;
	";	
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	
} /* if */


$this->view->render($data,'classrooms/roster');


}	/* fxn */



public function edit($params){
require_once(SITE."functions/details.php");
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);

if(isset($_POST['submit'])){
	unset($_POST['submit']);
	$post=$_POST;
	$db->update("{$dbg}.05_classrooms",$post," `id` = '$crid'  ");
	$url="classrooms/edit/$crid/$sy";
	flashRedirect($url,'Classroom edited.');
}	/* post */

$data['is_active']=$classroom['is_active'];
if(!isset($_SESSION['levels'])){ $_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id"); }
$data['levels']=$_SESSION['levels'];
if(!isset($_SESSION['sections'])){ $_SESSION['sections']=fetchRows($db,"{$dbo}.`05_sections`","id,code,name","code"); }
$data['sections']=$_SESSION['sections'];
if(!isset($_SESSION['majors'])){ $_SESSION['majors']=fetchRows($db,"{$dbo}.`05_majors`","*","code"); }
$data['majors']=$_SESSION['majors'];
if(!isset($_SESSION['departments'])){ $_SESSION['departments']=fetchRows($db,"{$dbo}.`05_departments`","*","id"); }
$data['departments']=$_SESSION['departments'];


$this->view->render($data,'classrooms/editClassroom');


}	/* fxn */


public function level($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/classrooms.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/contactsFxn.php");

	$lvlid=isset($params[0])? $params[0] : 1;
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$_SESSION['url'] = "mis/classrooms/$lvlid/$sy/$qtr"; 
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	
	$data['level_id']=$level_id=$lvlid;
	$data['brid']=$brid=(!isset($_GET['brid']))? $_SESSION['brid']:$_GET['brid'];
	$_SESSION['classrooms']['level_id'] = $level_id;
	$data['level']=getLevelDetails($db,$level_id,$dbg);	
	$cond_lvl = isset($_GET['all'])? NULL:" AND cr.level_id = '$level_id'";	
	// $cond_brid = isset($_GET['brid'])? " AND cr.branch_id = $brid ":NULL;	
	$cond_brid=
	$q = "SELECT cr.*,sec.name AS section,sec.code AS section_code,l.code AS level,a.name AS adviser,cr.id AS crid
			FROM {$dbg}.05_classrooms AS cr 
				INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
				INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
				LEFT JOIN {$dbo}.`00_contacts` AS a ON cr.acid = a.id
			WHERE cr.branch_id=$brid $cond_lvl ORDER BY l.id,sec.name LIMIT 100";
	debug($q);
	$sth = $db->querysoc($q);		
	$data['classrooms'] = $sth->fetchAll();	
	
	if(!isset($_SESSION['sections'])){ $_SESSION['sections']=fetchRows($db,"{$dbo}.`05_sections`","*","name"); }			
	$data['sections']=$_SESSION['sections'];		
	if(!isset($_SESSION['levels'])){ $_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name,","name"); }			
	$data['levels']=$_SESSION['levels'];			
	$data['num_classrooms']=count($data['classrooms']);
	
	if(!isset($_SESSION['teachers'])){ $_SESSION['teachers']=getContacts($db,RTEAC); } 	
	$data['teachers']=$_SESSION['teachers'];
	
	if(!isset($_SESSION['coordinators'])){ $_SESSION['coordinators']=getContacts($db,RACAD); } 	
	$data['coordinators']=$_SESSION['coordinators'];
	$data['crid']=$crid=lastID($db,"{$dbg}.05_classrooms");
		
	if(isset($_POST['add'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$label=$post['label'];
			$label = ($post['is_sped']==1)? $label."-S":$label;
			$q.= "INSERT IGNORE INTO {$dbg}.05_classrooms(`id`,`level_id`,`section_id`,`label`,`num`) VALUES 
					('".$post['crid']."','".$post['level_id']."','".$post['section_id']."',
						'$label','".$post['num']."'); ";
			$q.="INSERT IGNORE INTO {$dbg}.05_advisers_quarters(`crid`) VALUES('".$post['crid']."'); ";
			$q.="INSERT IGNORE INTO {$dbg}.05_promotions(`crid`) VALUES('".$post['crid']."'); ";
		}	
		$db->query($q);
		
		/* 2 - rename */
		updateAllClassroomName($db,$sy);		
		
		$get = isset($_GET['all'])? '?all':NULL;
		$url = "classrooms/level/$level_id".$get;
		flashRedirect($url,'Classrooms added.');exit;	
	}	/* post */
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.`05_classrooms` SET `name`='".$post['name']."',
				`label`='".$post['label']."',`acid`='".$post['acid']."' WHERE `id`='".$post['crid']."' LIMIT 1;";				
		}
		$db->query($q);
		$url="classrooms/level/$lvlid";
		flashRedirect($url,"Updated.");
		exit;
	}	
	$vfile="classrooms/levelClassrooms";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


/* view should be in teachers folder */
public function clscrs($params){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/reports.php");
$db =& $this->model->db;

$data['crid']	= $crid 	= isset($params[0])? $params[0] : '1';
$data['ssy']	= $ssy 	= DBYR; 
$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;

$_SESSION['url'] = "mis/clscrs/$crid/$sy";
$_SESSION['courses']['crid'] = $crid;
$dbg=VCPREFIX.$sy.US.DBG;	
$data['home']	= $home	= $_SESSION['home'];
$data['user']	= $user	= $_SESSION['user'];

	if(isset($_POST['submit'])){
		$courses = $_POST['courses'];
		$q = "";
		foreach($courses AS $row){
			$q .= " UPDATE {$dbg}.05_courses SET 
						
`name` = '".$row['name']."',`code` = '".$row['code']."',`label` = '".$row['label']."',
`subject_id` = '".$row['subject_id']."',`supsubject_id` = '".$row['supsubject_id']."',
`tcid` = '".$row['tcid']."',`crstype_id` = '".$row['crstype_id']."',`is_active` = '".$row['is_active']."',
`with_scores`  = '".$row['with_scores']."',`is_kpup` = '".$row['is_kpup']."',
`is_displayed` = '".$row['is_displayed']."',`in_genave` = '".$row['in_genave']."',
`affects_ranking` = '".$row['affects_ranking']."',`is_aggregate` = '".$row['is_aggregate']."',
`is_transmuted` = '".$row['is_transmuted']."',`course_weight`  = '".$row['course_weight']."',
`position`  = '".$row['position']."',`indent`  	= '".$row['indent']."',
`semester`  = '".$row['semester']."',`is_num`  = '".$row['is_num']."',`schedule`  = '".$row['schedule']."'
					WHERE `id` = '".$row['id']."';
			";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/clscrs/$crid/$sy";
		redirect($url);		
	
	}	/* post */
	
	/* process */
	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	$_SESSION['course']['level_id'] = $data['classroom']['level_id'];
	$order = "crs.semester,crs.crstype_id,crs.position,crs.id";
	$data['courses'] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$data['num_courses'] = count($data['courses']);
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['teachers'] 		= $this->model->getContacts(RTEAC);
	$data['coordinators'] 	= $this->model->getContacts(RACAD);
	$_SESSION['courses']['crid'] = $crid;
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
		
	$this->view->render($data,'mis/clscrs');

}	/* fxn */


public function id($params){
$dbo=PDBO;
$crid=$params[0];
$db=$this->model->db;
$dbg=PDBG;
$q="SELECT l.name AS level,s.name AS section,cr.name AS classroom 
FROM {$dbg}.05_classrooms AS cr
LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
WHERE cr.id ='$crid' LIMIT 1;
";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
if(isset($_GET['debug'])){ pr($q); }

$this->view->render($data,'classrooms/idClassroom');


}	/* fxn */


public function all($params=NULL){
$db=$this->model->db;
$sy=isset($params[0])? $params[0]:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$srid=$_SESSION['srid'];
$ar=array(RTEAC,RMIS,RREG,RADMIN);
if(!in_array($srid,$ar)){ flashRedirect(); }
if(($srid==RTEAC) && ($_SESSION['user']['privilege_id']!=0)) { flashRedirect(); }

$q="SELECT cr.id AS crid,l.name AS level,s.name AS section,cr.name AS classroom,
c.id AS acid,c.name AS adviser,ctp.ctp,c.account
FROM {$dbg}.05_classrooms AS cr
LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id 
LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id 
LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id=c.id 
ORDER BY l.id,s.id; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
if(isset($_GET['debug'])){ pr($q); }

$this->view->render($data,'classrooms/allClassrooms');


}	/* fxn */



public function adviser($params){
$dbo=PDBO;$db=$this->model->db;$dbg=PDBG;
$crid=isset($params[0])? $params[0]:false;
$srid=$_SESSION['srid'];
$ar=array(RTEAC,RMIS,RREG,RADMIN);
if(!in_array($srid,$ar)){ flashRedirect(); }
if(($srid==RTEAC) && ($_SESSION['user']['privilege_id']!=0)) { flashRedirect(); }

if(isset($_POST['submit'])){
	$acid=$_POST['post']['acid'];
	$q="UPDATE {$dbg}.05_classrooms SET `acid`='$acid' WHERE `id`='$crid' LIMIT 1;  ";
	$db->query($q);
	flashRedirect("classrooms/adviser/$crid","Adviser updated.");	
	exit;
}	/* post */

$q="SELECT c.name AS adviser,cr.name AS classroom,cr.id AS crid,cr.acid FROM {$dbg}.05_classrooms AS cr 
LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id WHERE cr.id='$crid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'classrooms/adviserClassroom');

}	/* fxn */


public function add(){
	$data['sy']=DBYR;	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		extract($post);
		if(!$level_id){ echo "level required. "; }
		if(!$section_id){ echo "section id required. "; }
		if($level_id && $section_id){ 
			// echo "<br /> get section label - add section"; 
			$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
			$lvlrow=fetchRow($db,"{$dbo}.05_levels",$level_id,"id,code,name");
			$sxnrow=fetchRow($db,"{$dbo}.05_sections",$section_id,"id,code,name");			
			$post['name']=$lvlrow['code'].'-'.$sxnrow['name'];
			$post['label']=$sxnrow['name'];
			
			$sth=$db->add("{$dbg}.05_classrooms",$post);			
			$msg=$sth? "Success":"Fail";
			$url='classrooms/level/'.$level_id;
			flashRedirect($url,$msg);
		}		
		exit;		
	}	/* post */
	
	
	$data['levels']=$_SESSION['levels'];
	$this->view->render($data,"classrooms/addClassroom");	
	
}	/* fxn */




}	/* ClassroomsController */
