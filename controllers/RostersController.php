<?php

Class RostersController extends Controller{	

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




public function classroom($params=NULL){
require_once(SITE."functions/classyear.php");
require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/sectionerFxn.php");

$data['crid']=$crid=isset($params[0])? $params[0]:1;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['home']=$home=$_SESSION['home'];
$data['srid']=$srid=$_SESSION['srid'];
$data['brid']=$brid=$_SESSION['brid'];
$fields="id,name";$order="level_id,section_id";$where="WHERE branch_id=$brid";
$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order,$where);
$data['classroom']=getClassroomDetails($db,$crid);
$acid=$data['classroom']['acid'];
if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
$data['branches']=$_SESSION['branches'];


if(!canViewClasslist($db,$acid,$crid)){ flashRedirect($home); }
if(($_SESSION['srid']==RTEAC) && ($_SESSION['settings']['advsxn_setup']!=1)){ flashRedirect($home); }
$lvl = $data['classroom']['level_id'];

if($crid){
	$data['rows']=rosterList($db,$dbg,$crid);
	$data['count']=count($data['rows']);	
} /* if */

$data['mis']=($srid==RMIS)? true:false;


$this->view->render($data,'rosters/classroomRosters');


}	/* fxn */


public function batchByScid($params=NULL){

require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['qtr']=$qtr=$_SESSION['qtr'];
$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['classroom']=getClassroomDetails($db,$crid,$dbg);
$lvl=$data['classroom']['level_id'];
$data['acid']=$acid=$data['classroom']['acid'];

$data['message']=$message=($qtr!=1)?"<h3 class='brown'>*NOT Qtr1 | &override.</h3>":false;

if(isset($_POST['add'])){
	$posts=$_POST['posts'];		
	$q="";
	foreach($posts AS $scid){
		$empty=(empty($scid))? true:false;
		if(!$empty){ $q.=sxnThisQuery($db,$sy,$scid,$crid); }		
	}	
	// pr($q);exit;
	$db->query($q);$url="rosters/batchByScid/$crid/$sy";
	flashRedirect($url,'Batch roster processed.');	
	exit;
}	/* post */

if($crid){ $data['rows']=rosterList($db,$dbg,$crid);$data['count']=count($data['rows']); } 
$vfile="rosters/batchByScidRosters";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function batch($params=NULL){
$acl = array(array(5,0));
$this->permit($acl);				
require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['qtr']=$qtr=$_SESSION['qtr'];
$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");

if($crid){
	$data['classroom']=getClassroomDetails($db,$crid,$dbg);
	$lvl=$data['classroom']['level_id'];
	$data['acid']=$acid=$data['classroom']['acid'];	
} 	/* crid */

	$data['message']=$message=($crid && $qtr!=1)?"<h3 class='brown'>*NOT Qtr1 | &override.</h3>":false;


if(isset($_POST['add'])){
	$posts = $_POST['posts'];		
	$q = "";	
	if(($_SESSION['qtr']==1) || isset($_GET['override'])){
		foreach($posts AS $code){
			$empty = (empty($code))? true:false;
			if(!$empty){
				$code = preg_replace("([^A-Za-z0-9-/])", "", $code);					
				$qry="SELECT id FROM {$dbo}.`00_contacts` WHERE code='$code' LIMIT 1; ";
				$sth=$db->querysoc($qry);$row=$sth->fetch();		
				$scid=$row['id'];
				$q.=sxnThisQuery($db,$sy,$scid,$crid);	
			}		
		}		
	} 		
	$db->query($q);			
	$url = "rosters/batch/$crid/$sy";
	flashRedirect($url,'Batch roster processed.');	
	exit;

}	/* post */

/* data */
if($crid){ $data['rows']=rosterList($db,$dbg,$crid);$data['count']=count($data['rows']); } 
 
$vfile="rosters/batchRosters";vfile($vfile); 
$this->view->render($data,$vfile);

}	/* fxn */



public function sync($params=NULL){
require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['sy'] = $_SESSION['sy'];
$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
$lvl = $data['classroom']['level_id'];
$data['acid'] = $acid = $data['classroom']['acid'];

$data['tmpcrid']=tmpcrid($db,$dbg,$lvl,$crid);
$data['outcrid']=outcrid($db,$dbg,$lvl,$crid);

$data['tmpcrid'] = $tmpcrid = $data['outcrid'];

if($crid){
	$data['rows'] = $rows = rosterList($db,$dbg,$crid);
	$data['count'] = count($data['rows']);
	$ar   = buildArray($rows,'scid');
	
} /* if */

if(isset($_POST['sync'])){
	$posts = $_POST['posts'];
	$q = "";
	$br = array();
	foreach($posts AS $code){
		$empty = (empty($code))? true:false;
		if(!$empty){
			$code = preg_replace("([^A-Za-z0-9-/])", "", $code);
			$qry = "SELECT id AS scid,crid AS prevcrid FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1;";
			$sth = $db->querysoc($qry);
			$row = $sth->fetch();
			$br[] = $row['scid'];
			
			/* 1 */			
			if($row){ 
				$q.= sxnThis($db,DBYR,$scid,$crid); 
			}	
			
			
		}		
	}	/* foreach */
	
	$tx = array_diff($ar,$br);
	$ix = array_diff($br,$ar);	
	$q="";
	foreach($tx AS $scid){	
		$row['scid'] = $scid;
			$q.= sxnThis($db,DBYR,$scid,$crid);		
	}	/* foreach */

	$db->query($q);
	$url="rosters/sync/$crid/$sy";
	flashRedirect($url,'Roster Sync	ed.');
	exit;
	
}	/* post */


$this->view->render($data,'rosters/sync');


}	/* fxn */




public function keys($params=NULL){
require_once(SITE."functions/rosters.php");
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$dbyr=DBYR;
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
$lvl = $data['classroom']['level_id'];
$data['acid'] = $acid = $data['classroom']['acid'];

if(isset($_POST['add'])){
	$posts = $_POST['posts'];		
	$q = "";
	foreach($posts AS $key){
		// pr($code);
		$empty = (empty($key))? true:false;
		if(!$empty){
			$q.="UPDATE {$dbg}.05_summaries SET `prevcrid`=`crid`,`crid`='$crid',`acid`='$acid' WHERE `scid`='$key' LIMIT 1;";
		}		
	}	
	// pr($q);exit;
	$db->query($q);	
	if($_SESSION['settings']['has_axis']){
		require_once(SITE."functions/syncSummaries.php");	
		syncTsum($db,$crid,$dbg);
		updateTsumCrid($db,$crid,$dbg);
	}
	
	$url = "rosters/keys/$crid/$sy";
	flashRedirect($url,'Batch roster keys processed.');	
	exit;

}	/* post */


$data['tmpcrid']=tmpcrid($db,$dbg,$lvl,$crid);
$data['outcrid']=outcrid($db,$dbg,$lvl,$crid);

if($crid){
	$data['rows'] = rosterList($db,$dbg,$crid);
	$data['count'] = count($data['rows']);
	$data['q']=isset($_SESSION['q'])? $_SESSION['q']:NULL;
	
} /* if */

$this->view->render($data,'rosters/keys');

}	/* fxn */


public function releaseCridStudents($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

	$q="UPDATE {$dbg}.05_summaries SET crid=0 WHERE crid=$crid; ";
	pr($q);
	$url="rosters/releaseCridStudents/$crid?exe";
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		

}	/* fxn */


public function rollback($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:1;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];

	/* 1  */
	$q="SELECT summ.scid,summ.crid,summ.prevcrid,c.name AS studname
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		WHERE summ.prevcrid=$crid OR summ.crid=$crid
		ORDER BY $order;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	/* 2 - classroom */
	$data['classroom']=fetchRow($db,"{$dbg}.05_classrooms",$crid);

	
	$this->view->render($data,"rosters/rollback");
	
	
	
}	/* fxn */


public function drafter($params=NULL){
	require_once(SITE."functions/dbtools.php");
	$data['params']=$params;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;	
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;	
	$data['dbo']=$dbo=PDBO;	
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	$data['srid']=$srid=$_SESSION['srid'];

	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0),array(7,0));
	$this->permit($acl);				


	/* 2 post */	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		extract($post);
		$q="";
		$q.="UPDATE {$dbg}.05_summaries SET prevcrid=$prevcrid,crid=$crid WHERE scid=$scid LIMIT 1; ";
		$q.="UPDATE {$dbo}.05_enrollments SET crid=$crid WHERE scid=$scid AND sy=$sy LIMIT 1; ";
		$sth=$sth=$db->query($q);		
		
		flashRedirect("rosters/drafter/$scid","Updated draft.");			
		exit;		
	}

	/* process */
	if($scid){
		$q="SELECT c.is_active,c.is_cleared,c.id AS ucid,c.parent_id AS pcid,c.code,c.name,summ.scid,summ.prevcrid,summ.crid,
				cr.name AS classroom,p.birthdate
			FROM {$dbo}.00_contacts AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
			WHERE summ.scid=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['student']=$sth->fetch();
		
		
	}	/* scid */			
	
	/* 4 */
	$vfile="rosters/drafter";vfile($vfile);
	$this->view->render($data,$vfile);
		
}	/* fxn */




}	/* RostersController */
