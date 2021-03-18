<?php

Class SectioningController extends Controller{	

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




public function crid($params=NULL){
$dbo=PDBO;
if($_SESSION['srid']!=RMIS){ $home=$_SESSION['home']; flashRedirect($home,'Only allowed for MIS'); }

	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sectioningFxn.php");
	require_once(SITE."functions/logs.php");
	$db =& $this->model->db;

	$data['crid']	= $crid = isset($params[0])? $params[0]:1;	
	$prevcrid = $crid;	/* for prevcrid */
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : DBYR;
	$data['psy']=$sy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];	
	$_SESSION['url']	= "sectioning/crid/$crid/$sy";		
	$data['current'] = $current = ($sy==DBYR)? true : false;	
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;

	// $order = "c.is_male DESC,c.name";
	$order = $_SESSION['settings']['classlist_order'];
	$data['rows'] = $rows = sectioningClass($db,$sy,$crid,$male=2,$order,$fields=NULL,$filter=NULL);	
	$data['count']	= count($data['rows']);
	

		
if(isset($_POST['submit'])){
$posts = $_POST['posts'];
$q = "";
$i=0;
foreach($posts AS $post){
	$scid = $post['scid'];
	$postcrid=$post['crid'];
	$enid=$post['enid'];
	
	
	/* 1 - contacts */		
	if($current){ $q.="UPDATE {$dbo}.`00_contacts` SET `sy`=$sy,`crid`=$postcrid WHERE id=$scid LIMIT 1;"; }
				
	/* 2 - summaries */		
	$q.=" UPDATE {$dbg}.05_summaries SET prevcrid=crid,`crid`= $postcrid WHERE `scid`=$scid LIMIT 1;";	
	$q.=" UPDATE {$dbo}.05_enrollments SET `crid`= $postcrid WHERE `id`=$enid LIMIT 1;";	
	
	
	$i++;
}	/* foreach */

$db->query($q);

	/* 2 */
	$axn = $_SESSION['axn']['sectioning'];
	$details = "";
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['crid'] = $prevcrid;
	logThis($db,$ucid,$axn,$details,$more);	

	$url = "sectioning/crid/$crid/$sy";
	$this->flashRedirect($url,'Updated sectioning.');

	exit;

}	/* post */

	$data['classroom'] = getSimpleClassroomDetails($db,$crid,$dbg);	
	$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	

	$key = 'sectioning';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];
	$vfile="sectioning/cridSectioning";vfile($vfile);
	$this->view->render($data,$vfile);	

}	/* fxn */




public function level($params=NULL){
$dbo=PDBO;
if($_SESSION['srid']!=RMIS){ $home=$_SESSION['home']; flashRedirect($home,'Only allowed for MIS'); }

	require_once(SITE."functions/details.php");
	require_once(SITE."functions/enrollment.php");
	require_once(SITE."functions/logs.php");	
	$db =& $this->model->db;

	$data['level_id']	= $level_id 	= isset($params[0])? $params[0]:1;

	$data['sy']		= $sy 	= isset($params[1])? $params[1] : DBYR;
	$data['psy']=$sy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];	
	$_SESSION['url']	= "sectioning/level/$level_id/$sy";		
	$data['current'] = $current = ($sy==DBYR)? true : false;	
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;	
	$limit = 500;	
				
	if(isset($_POST['edit'])){ $_SESSION['readonly'] = false; }
	if(isset($_POST['done'])){ $_SESSION['readonly'] = true; }

	$order = isset($_GET['grp'])? "c.grp,c.is_male DESC,c.name":NULL;			
	$data['rows'] = $rows = sectioningLevel($db,$dbg,$level_id,$limit,$order,$fields=NULL,$filter=NULL);
	$data['count'] = count($data['rows']);

/* sync tsum */		

/* sync */		
	
	
if(isset($_POST['submit'])){
$posts = $_POST['students'];
$q = "";
$i=0;
foreach($posts AS $post){
	$scid = $post['scid'];
	$postcrid = $post['crid'];
		
	/* 2 - summaries */		
	$q.=" UPDATE {$dbg}.05_summaries SET `crid` = '$postcrid' WHERE `scid` = '$scid' LIMIT 1;";	
				
	/* echo (isset($student['sumscid']))? 'sumscid set':'sumscid NOT set'; */
/* 3 - init students,profiles,photos,ctp if not exists */	
	$i++;
}	/* foreach */

$db->query($q);

	/* 2 */
	$axn = $_SESSION['axn']['sectioning'];
	$details = "";
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['lvlid'] = $level_id;
	logThis($db,$ucid,$axn,$details,$more);	

$url = "sectioning/level/$level_id/$sy";
$this->flashRedirect($url,'Updated sectioning.');

exit;

}	/* post */

		
	$fields = "*";
	if(isset($_GET['sxns'])){
		$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id,section_id");		
	} else {
		$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","section_id","WHERE level_id='$level_id' ");			
	}
	$data['level']	= getLevelDetails($db,$level_id,$dbg);
	$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,code,name","id");	
		
	$key = 'sectioningLevel';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];
	$data['has_axis'] = $_SESSION['settings']['has_axis'];
	
	$this->view->render($data,'sectioning/level');
	
}	/* fxn */

  

public function reverse($params=NULL){
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;
	$q=" UPDATE {$dbg}.05_summaries SET crid=prevcrid WHERE prevcrid=$crid; ";

	pr("Summaries: ".$q); 	
	if(isset($_GET['exe'])){
		$sth=$db->query($q);echo ($sth)? "Success":"Fail";		
	}
	
if($sy==DBYR){
	$q="UPDATE {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		SET c.crid=summ.prevcrid WHERE summ.prevcrid=$crid; ";
	pr("Contacts-Current Year");pr($q); 		
	if(isset($_GET['exe'])){
		$sth=$db->query($q);echo ($sth)? "Success":"Fail";	
	}
}	/* current */
	
	// 3	
	$q="UPDATE {$dbo}.05_enrollments AS en 
		INNER JOIN {$dbg}.05_summaries AS summ ON (en.sy=$sy && summ.scid=en.scid)
		SET en.crid=summ.prevcrid WHERE summ.prevcrid=$crid; ";
	pr("Enrollments: ");pr($q); 	
	if(isset($_GET['exe'])){		
		$sth=$db->query($q);echo ($sth)? "Success":"Fail";		
	}
	
	
	
}	/* fxn */



public function grp(){	// alpha
	$db=$this->baseModel->db;
	$dbo=PDBO;$dbg=PDBG;
	$ndbg=VCPREFIX.(DBYR+1).US.DBG;
	$scid=3171;
	
	$q="SELECT c.code AS studcode,c.name AS student,
			ccr.name AS curr_classroom,ccr.level_id AS curr_lvl,ccr.grp AS curr_grp
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS ccr ON summ.crid=ccr.id		
		WHERE c.id=$scid LIMIT 1; ";

	$crid=12;
	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS student,
			ccr.name AS curr_classroom,ccr.level_id AS curr_lvl,ccr.grp,
			ncr.name AS next_classroom,
			ncr.level_id AS next_lvl
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS ccr ON summ.crid=ccr.id		
		LEFT JOIN {$dbg}.05_classrooms AS ncr ON (ncr.level_id=ccr.level_id+1 && ccr.grp=ncr.grp)		
		WHERE summ.crid=$crid; ";		
	$sth=$db->querysoc($q);
	pr($q);	
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$this->view->render($data,"sectioning/grpSectioning");
		
	
}





}	/* SectioningController */
