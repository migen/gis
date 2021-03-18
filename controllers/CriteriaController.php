<?php

Class CriteriaController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */


public function index1($params=NULL){
	echo "Criteria";shovel('links_gset');
}

public function index(){
	$this->view->render($data=NULL,"criteria/indexCriteria");
}	/* fxn */


public function set($params=NULL){
	$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$order=(isset($_GET['order']))? $_GET['order']:"id";
	$data['rows']=fetchRows($db,"{$dbo}.`05_criteria`","*",$order);
	$data['count']=count($data['rows']);
	$this->view->render($data,'criteria/setCriteria');

}	/* fxn */




public function editable($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/criteria.php");
	$db=&$this->model->db;$dbg=PDBG;
		
	if(isset($_POST['add'])){
		// pr($_POST);
		$q = "INSERT IGNORE INTO {$dbo}.`05_criteria` (`name`,`code`,`crstype_id`,`critype_id`) VALUES ";
		$rows = $_POST['criteria'];
		foreach($rows AS $row){
			if(!empty($row['name'])){
				$q.="('".$row['name']."','".$row['code']."','".$row['crstype_id']."','".$row['critype_id']."'),";			
			}
		}	/* foreach */		
		$q=rtrim($q,",");$q.=";";
		// pr($q);exit;
		$db->query($q);
		redirect("criteria");		
		exit;
	}	/* post-add */	
	
/* -------------- edit -------------- */
	if(isset($_POST['edit'])){
		$rows = $_POST['criteria'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`05_criteria` SET `code` = '".$row['code']."',`critype_id`='".$row['critype_id']."',
				`position`='".$row['position']."',`is_active`= '".$row['is_active']."',`is_kpup_list`= '".$row['is_kpup_list']."',
				`is_raw`= '".$row['is_raw']."'WHERE `id`='".$row['cid']."' LIMIT 1;	";		
		}	/* foreach */
		$db->query($q);
		redirect("criteria");	
	}	/* post-editAll */

	/* for batch delete */
	if(isset($_POST['batch'])){
		$ids = $_POST['rows'];
		foreach($ids AS $id){ deleteCriteria($db,$id); }
		redirect("criteria");		
	}
	
/* -------------- data --------------------------------------------------------------------- */

	$data['departments']=$this->model->fetchRows("".PDBO.".`05_departments`");	
	$sort = isset($_GET['sort'])? $_GET['sort']:false;
	$order = isset($_GET['order'])? $_GET['order']:"DESC";
	$data['criteria']=criteriaDetails($db,$dbg,$sort,$order);
	$data['crstypes']=$this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['num_criteria']=count($data['criteria']);
	$this->view->render($data,'criteria/editableCriteria');
	
}	/* fxn */




public function delete($params){
	sudo();
	$dbo=PDBO;$dbg=PDBG;
	$criteria_id = $params[0];
	$q = " DELETE FROM {$dbo}.`05_criteria` WHERE `id` = '$criteria_id' LIMIT 1; ";
	$this->model->db->query($q);
	$url = 'criteria';
	flashRedirect($url,'Criteria Deleted!');
} 	/* fxn */


public function ranks($params){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/scores.php");
require_once(SITE."functions/grades.php");
require_once(SITE."functions/students.php");
$db	=&	$this->model->db;

$data['home']	=	$home = $_SESSION['home']; 			
$course_id 	 	= $params[0];
$criteria_id 	= $params[1];
$data['ssy']	= $ssy	= $_SESSION['sy'];	

$sy = isset($params[2])? $params[2]:$ssy;
$qtr = isset($params[3])? $params[3]:$_SESSION['qtr'];
$srid = $_SESSION['srid'];

$dbg = VCPREFIX.$sy.US.DBG;			
$_SESSION['url'] = "criteria/ranks/$course_id/$criteria_id/$sy/$qtr";
	
if($srid==RTEAC){ 	
	if((!in_array($course_id,$_SESSION['teacher']['course_ids']))) { flashRedirect('teachers'); } 
}	
		
$course = $data['course'] 	= getCourseDetails($db,$course_id);
$_SESSION['course'] 		= $course;
		
$data['curr_qtr'] 		 = $_SESSION['qtr'];
$data['is_locked'] 		 = $course['is_finalized_q'.$qtr];
$data['course_id']		 = $course_id;
$data['qtr'] 		 	 = $qtr;

$crid			  = $course['crid'];	
$order="c.is_male DESC,c.name";
$data['kpup']	  = $kpup	= $course['is_kpup']; 
$data['students'] 	= classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order );		
		
if($kpup){
	$data['activities'] = $this->model->getSubcriteriaActivities($dbg,$course_id,$criteria_id,$qtr);	
	foreach($data['students'] AS $student){ $data['scores'][] = $this->model->getSubcriteriaScores($dbg,$course_id,$criteria_id,$student['scid'],$qtr);	}		
} else {
	$data['activities'] = getCriteriaActivities($db,$dbg,$course_id,$criteria_id,$qtr);	
	foreach($data['students'] AS $student){ $data['scores'][] = getCriteriaScores($db,$dbg,$course_id,$criteria_id,$student['scid'],$qtr);	}		
}		
		
$data['num_students'] 	= count($data['students']);
$data['num_scores'] 	= isset($data['scores'])? count($data['scores']) : 0;
$data['num_activities'] = count($data['activities']);


$data['selects'] 		= $this->model->selectsCourseCriteria($course_id);						
$this->view->render($data,'criteria/ranks');
			

}	/* fxn */




public function edit($params){
	$dbo=PDBO;
	$criteria_id = $params[0];
	require_once(SITE."functions/classifications.php");	
	$db=&$this->baseModel->db;
	$ssy	= $_SESSION['sy'];
	$dbg=PDBG;

	if(isset($_POST['edit'])){		
		$row = $_POST['criteria'];
		$sqlCrsType = classifyCourseType($row['crstype_id']);
		$name=addSlashes($row['name']);
		$q = " UPDATE {$dbo}.`05_criteria` SET `name` = '$name',`crstype_id`= '".$row['crstype_id']."',`critype_id`= '".$row['critype_id']."',
			`code` = '".$row['code']."',`position` = '".$row['position']."',`is_active` = '".$row['is_active']."',`is_raw` = '".$row['is_raw']."',
			`is_kpup` = '".$row['is_kpup']."',`is_kpup_list` = '".$row['is_kpup_list']."',";
		$crstype_id = $row['crstype_id'];		
		$department_id = 5;
		$sqlDept = classifyDepartmentForEdit($department_id,'');
		$q .= $sqlDept;		
		$q .= " WHERE `id` = '".$row['id']."';  ";
		// pr($q);exit;
		$db->query($q);
		flashRedirect("criteria/edit/$criteria_id","Updated.");
		exit;
	
	}	/* post-edit */

	$data['criteria'] = $this->model->getCriteriaDetails($criteria_id);
	$data['crstypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['critypes'] = $this->model->fetchRows("{$dbo}.`05_critypes`");
	$data['departments']  = $this->model->fetchRows("".PDBO.".`05_departments`");	
	
	$this->view->render($data,'criteria/editCriteria');


}	/* fxn */




public function one(){
$dbo=PDBO;$dbg=PDBG;
$q="INSERT INTO {$dbg}.05_components(`id`,`level_id`,`subject_id`,`weight`,`criteria_id`)VALUES ";
for($i=15;$i<80;$i++){
	$id=1023+$i;
	$q.="($id,1,91,100,$i),";
}
$q=rtrim($q,",");$q.=";";
pr($q);



}	/* fxn */



public function add(){
$dbo=PDBO;
$db=&$this->model->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$criname=$post['name'];
	$db->add("{$dbo}.`05_criteria`",$post);
	flashRedirect("criteria","$criname criteria added.");
	exit;
}	/* post */

$data['crstypes']=fetchRows($db,"{$dbo}.`05_crstypes`");
$this->view->render($data,'criteria/addCriteria');

}	/* fxn */


public function traits(){
$dbo=PDBO;
$db=&$this->baseModel->db;$dbg=PDBG;
$crstype_id=isset($_GET['crstype_id'])? $_GET['crstype_id']:CTYPETRAIT;
$critype_id=isset($_GET['critype_id'])? $_GET['critype_id']:1;
debug($crstype_id,'crstype_id');
$allwhere=(isset($_GET['all']))? NULL:"AND cri.crstype_id='$crstype_id'";
$crswhere=(isset($_GET['crstype_id']))? "AND cri.crstype_id='$crstype_id'":NULL;
$criwhere=(isset($_GET['critype_id']))? "AND cri.critype_id='$critype_id'":NULL;
$order=(isset($_GET['order']))? "ORDER BY ".$_GET['order']: "ORDER BY cri.critype_id,cri.name"; 


if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$q.="UPDATE {$dbo}.`05_criteria` SET critype_id='".$post['critype_id']."' WHERE id='".$post['id']."' LIMIT 1; ";
	}
	$db->query($q);
	$get=sages($_GET);
	$url="criteria/traits$get";
	flashRedirect($url,'Saved.');	
	exit;
	
}	/* post */

$q="SELECT cri.*,cri.critype_id AS critype_id,cri.crstype_id AS crstype_id 
	FROM {$dbo}.`05_criteria` AS cri WHERE 1=1 $allwhere $crswhere $criwhere $order; ";
debug($q,'Q');
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$data['critypes']=fetchRows($db,"{$dbo}.`05_critypes`","id,name","id");

$this->view->render($data,'criteria/traitsCriteria');

}	/* fxn */










}	/* CriteriaController */
