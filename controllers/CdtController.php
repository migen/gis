<?php

Class CdtController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}




public function index($params=NULL){

	$db=&$this->baseModel->db;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	if(!isset($_SESSION['classrooms'])){
		$brid=$_SESSION['brid'];$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";		
		$_SESSION['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);				
		pr("sessionize-classrooms");
	}
	$data['classrooms']=$_SESSION['classrooms'];
	
	$vfile="cdt/indexCdt";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */

public function grades($params){
require_once(SITE.'functions/cdtFxn.php');
$data['crid']=$crid=$params[0];
$data['tcid']=$tcid=$params[1];
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
$order=$_SESSION['settings']['classlist_order'];

if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$id=$post['id'];$grade=$post['grade'];
		$q.="UPDATE {$dbg}.50_cdtgrades SET `q{$qtr}`= '$grade' WHERE `id`='$id' LIMIT 1; ";
	}
	$sth=$db->querysoc($q);
	$msg=($sth)? "Success":"Fail";
	$url="cdt/grades/$crid/$tcid";
	flashRedirect($url,$msg);
	exit;
	
}	/* post */

/* 1-classroom */
$data['classroom']=getClassroomConductDetails($db,$dbg,$crid);

// 2-acl
$data['course']=$course=getConductDetails($db,$dbg,$crid);		
$srid=$_SESSION['srid'];
$admin_roles=array(RMIS,RACAD,RREG);
$data['is_admin']=$is_admin=in_array($srid,$admin_roles);

$data['is_locked']=$is_locked=($course['conduct_q'.$qtr]==1)? true:false;
if($is_locked && !$is_admin && isset($_GET['edit'])){		
	flashRedirect("cdt/grades/$crid/$tcid","Locked - cannot edit");
} 


$data['cdtcrs']=$cdtcrs=$data['classroom']['cdtcrs'];
$data['acid']=$acid=$data['classroom']['acid'];

/* 1.5-acl */
$srid=$_SESSION['srid'];
$admin_roles=array(RMIS,RACAD);
$data['is_admin']=$is_admin=in_array($srid,$admin_roles);
$ucid=$_SESSION['ucid'];
$data['is_mine']=$is_mine=($tcid==$ucid)? true:false;
$data['is_allowed']=$is_allowed=($is_admin || $is_mine)? true:false;
if(!$is_allowed){ flashRedirect(UNAUTH); }

/* 2-classlist */
$data['rows']=getClasslistWithCdtcrsGrade($db,$dbg,$crid,$cdtcrs,$qtr,$order);
$data['num_classlist']=count($data['rows']);
$data['count']=&$data['num_classlist'];

/* 3-grades rows */
$data['grades']=getCdtgrades($db,$dbg,$crid,$tcid,$order,$qtr);
$data['num_grades']=count($data['grades']);

/* 4-teacher details */
$data['teacher']=fetchRow($db,"{$dbo}.`00_contacts`",$tcid);

$has_errors=false;
if($data['num_classlist']>$data['num_grades']){ 
	syncCdtgrades($db,$dbg,$crid,$tcid,$cdtcrs,$qtr,$order);
	$has_errors=true;	
	$url = "cdt/grades/$crid/$tcid";	
	echo "<a href='".URL.$url."' >Refresh</a>";	
}
$data['deciconducts']=$_SESSION['settings']['deciconducts'];
$data['has_errors']=&$has_errors;

$vfile='cdt/gradesCdt';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */


public function tally($params){
require_once(SITE.'functions/cdtFxn.php');
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];


$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
$order=$_SESSION['settings']['classlist_order'];

if(isset($_POST['submit'])){
	$posts=isset($_POST['posts'])? $_POST['posts']:array();
	$q="";
	foreach($posts AS $post){	
		$gid=$post['gid'];
		$scid=$post['scid'];
		$grade=$post['grade'];
		$q .= " UPDATE {$dbg}.50_grades SET `q$qtr` = '$grade' WHERE `id` = '$gid' LIMIT 1; ";			
		$q .= " UPDATE {$dbg}.05_summaries SET `conduct_q$qtr` = '$grade' WHERE `scid` = '$scid' LIMIT 1; ";			
	}	/* foreach */
	$sth=$db->query($q);
	$url="cdt/tally/$crid";
	flashRedirect($url,"Saved.");
	exit;

}	/* post */

/* 1-classroom */
$data['classroom']=getClassroomConductDetails($db,$dbg,$crid);

// 2-acl
$data['course']=$course=getConductDetails($db,$dbg,$crid);		

$srid=$_SESSION['srid'];
$admin_roles=array(RMIS,RACAD,RREG);
$data['is_admin']=$is_admin=in_array($srid,$admin_roles);

$data['is_locked']=$is_locked=($course['conduct_q'.$qtr]==1)? true:false;
if($is_locked && !$is_admin && isset($_GET['edit'])){		
	flashRedirect("cdt/tally/$crid","Locked - cannot edit");
} 


$data['cdtcrs']=$cdtcrs=$data['classroom']['cdtcrs'];

/* 1.5-acl */
$srid=$_SESSION['srid'];
$admin_roles=array(RMIS,RACAD,RREG);
$data['is_admin']=$is_admin=in_array($srid,$admin_roles);
$data['ucid']=$ucid=$_SESSION['ucid'];
$acid=$data['classroom']['acid'];
$is_adviser=($acid==$ucid)? true:false;
$data['is_allowed']=$is_allowed=($is_admin || $is_adviser)? true:false;
if(!$is_allowed){ flashRedirect(UNAUTH); }


/* 2-classlist */
// $data['rows']=getClasslist($db,$dbg,$crid,$order);
$data['rows']=getClasslistWithCdtcrsGrade($db,$dbg,$crid,$cdtcrs,$qtr,$order);
$data['num_classlist']=count($data['rows']);
$data['count']=&$data['num_classlist'];

/* 3-teachers */
$data['teachers']=getTeachersByClassroom($db,$dbg,$crid);
$data['numteacs']=$numteacs=count($data['teachers']);

/* 4-sync if needed */
$grades=array();
$numsub=array();
for($i=0;$i<$numteacs;$i++){
	$tcid=$data['teachers'][$i]['tcid'];
	$grades[$i]=getCdtgrades($db,$dbg,$crid,$tcid,$order,$qtr);
	$numsub[$i]=count($grades[$i]);
	if($numsub[$i]<$data['count']){
		syncCdtgrades($db,$dbg,$crid,$tcid,$cdtcrs,$qtr,$order);		
		$groups[$i]=getCdtgrades($db,$dbg,$crid,$tcid,$order,$qtr);		
	}		
}	/* for */
$data['grades']=&$grades;

$vfile='cdt/tallyCdt';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */






}	/* BlankController */
