<?php

Class LoadsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */



/* view should be in teachers folder */
public function teacher($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/loads.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/contactsFxn.php");
	$db =& $this->model->db;

	$data['home']	= $home	= $_SESSION['home'];
	$data['user']	= $user	= $_SESSION['user'];
	$data['is_teacher']	= $is_teacher	= ($user['role_id']==RTEAC)? true:false;
	$data['ssy'] = $ssy = $_SESSION['sy'];
	$data['sqtr'] = $sqtr = $_SESSION['qtr'];
	
	$tcid=isset($params[0])? $params[0]:false;
	$tcid=($is_teacher)? $user['ucid']:$tcid;	
	$data['tcid']=$tcid;	
	$data['sy']	= $sy	= isset($params[1])? $params[1]:$ssy;

	$dbg	= VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$courses = $_POST['courses'];
		$q = "";
		foreach($courses AS $row){
			$q .= " UPDATE {$dbg}.05_courses SET 
						`code`   	= '".$row['code']."',
						`label`  	= '".$row['label']."',
						`tcid`  	= '".$row['tcid']."',
						`is_active` = '".$row['is_active']."',
						`with_scores`  = '".$row['with_scores']."',
						`is_kpup` 	   = '".$row['is_kpup']."',
						`is_displayed` = '".$row['is_displayed']."',
						`in_genave`    = '".$row['in_genave']."',
						`affects_ranking` = '".$row['affects_ranking']."',
						`is_aggregate` = '".$row['is_aggregate']."',						
						`is_transmuted` = '".$row['is_transmuted']."',						
						`course_weight`  = '".$row['course_weight']."',
						`position`  = '".$row['position']."',
						`semester`  = '".$row['semester']."',
						`schedule`  = '".$row['schedule']."'
					WHERE `id` = '".$row['id']."';
			";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "loads/teacher/$tcid/$sy";
		$this->flashRedirect($url,'Courses updated!');		
	
	}	/* post */
	
	$dbo=PDBO;
	// $data['teacher']	  = getTeacherDetails($db,$tcid,$dbg);
	$q="SELECT c.id AS tcid,c.code AS teacher_code,c.name AS teacher,cr.name AS advisory
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.acid=c.id
		WHERE c.id='$tcid' LIMIT 1;
	";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['teacher']=$sth->fetch();
	
	
	$data['all']		  = $all	= (isset($_GET['all']))? true:false;
	$data['courses'] 	  = loads($db,$tcid,$dbg,$all); 
	$data['num_courses']  = count($data['courses']);
	// $data[]
	$data['coordinators'] 	= getContacts($db,RACAD);	
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
	$srid=$_SESSION['srid'];
	// $vfile=($srid==RMIS)? "loads/teacherLoadsEdit":"loads/teacherLoadsView";
	$vfile="loads/teacherLoadsView";
	if(isset($_GET['edit']) && $srid==RMIS){ $vfile="loads/teacherLoadsEdit"; }
	$this->view->render($data,$vfile);

}	/* fxn */


public function cls($params=NULL){
	require_once(SITE."functions/details.php");
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	$crid=$params[0];
	$data['crid']=&$crid;

	if(isset($_POST['submit'])){
		$q="";
		$posts=$_POST['posts'];		
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.05_courses SET `name`='".$post['course']."',`tcid`='".$post['tcid']."',
				`position`='".$post['position']."' WHERE `id`='".$post['crs']."' LIMIT 1;";
		}
		$db->query($q);
		flashRedirect("loads/cls/$crid","Courses updated.");
		exit;
	}
		
	$q="SELECT crs.name AS course,c.name AS teacher,crs.id AS crs,s.code AS subcode,s.name AS subject,
			crs.tcid,cr.name AS classroom,crs.label,crs.position
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=crs.tcid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS s ON crs.subject_id=s.id
		WHERE crs.crid='$crid';		
	";
	if(isset($_GET['debug'])){ pr("cridCourses"); pr($q); }
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	if(!isset($_SESSION['classrooms'])){ 
		sessionizeArray($db,'classrooms',"{$dbg}.05_classrooms",$order="level_id,section_id");		
	}	

	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	$data['classrooms']=$_SESSION['classrooms'];
	$this->view->render($data,'loads/clsLoads');	
	

}	/* fxn */


public function crlist(){
	$data=NULL;
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	$q="SELECT cr.id AS crid,cr.name AS classroom,cr.acid,c.name AS adviser
		FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		WHERE cr.section_id>1 ORDER BY cr.level_id;
	";
	if(isset($_GET['debug'])){ $data['q']=$q; }
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	
	$this->view->render($data,'loads/crlist');
}	/* fxn */

public function crids($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/loads.php');
	$tcid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	$db=&$this->model->db;$dbg=PDBG;		
	if((!isset($_SESSION['teacher']['crids'])) || (isset($_GET['reset']))){
		sessionizeTeacherCrids($db,$dbg,$tcid);
		flashRedirect("loads/crids","Teacher Crids reset.");
	}		
	$data['rows']=$_SESSION['teacher']['rcrids'];
	$data['count']=$_SESSION['teacher']['numcrids'];	
		
	$this->view->render($data,'loads/crids');

}	/* fxn */























}	/* BlankController */
