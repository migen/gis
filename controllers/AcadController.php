<?php

Class AcadController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::loginRedirect();
	
	/* 	http://localhost/gis/mis/classrooms/1 */
	$acl = array(array(4,0),array(5,0),array(9,0));
	/* 2nd param is strict,default is false	 */
	$this->permit($acl,0);		
	
}	/* fxn */





public function index(){
	$dbo=PDBO;
	$db=&$this->model->db;$dbg=PDBG;
	$data['home']=$_SESSION['home']; 	/* not session-home: admins*/
	$data['sy']=$_SESSION['sy'];$data['qtr']=$_SESSION['qtr'];	
	$user  = $_SESSION['user'];$srid  = $_SESSION['srid'];
	$admin = (($srid==RMIS) || ($srid==RREG))? true:false;
	$principal 	= (($srid==RACAD) && ($user['privilege_id']==0))? true:false;	
	$suco = (($srid==RACAD) && ($user['privilege_id']==1))? true:false;	
	$clco = (($srid==RACAD) && ($user['privilege_id']==2))? true:false;	
	$disc = (($srid==RACAD) && ($user['privilege_id']==4))? true:false;	
	$acst = (($srid==RACAD) && ($user['privilege_id']==5))? true:false;	
	if($suco){ redirect('acad/suco'); }
	if($clco){ redirect('clubs/all'); }
	if($disc){ redirect('cirr'); }
	if($acst){ redirect('acad/acst'); }
	if($admin || $principal){} else { $this->flashRedirect($home); }	
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`",'id,name','id');
	$data['classrooms']=fetchRows($db,$dbg.'.05_classrooms','id,name,acid AS acid','level_id,section_id');
	$vfile="acad/indexAcad";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */






public function suco(){
$dbo=PDBO;
$data['ucid']	= $ucid = $_SESSION['user']['ucid'];
$data['sy']		= $_SESSION['sy'];
$data['qtr']	= $_SESSION['qtr'];
$dbg = PDBG;
$dbg=&$dbg;

$q = "SELECT crs.*,crs.id AS course_id,cr.name AS classroom,sub.name AS subject
	FROM {$dbo}.`05_subjects_coordinators` AS sac 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sac.subject_id = sub.id
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.subject_id = sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
	WHERE sac.hcid = '$ucid'; ";
$sth = $this->model->db->querysoc($q);
$data['courses'] = $courses = $sth->fetchAll();
$data['count'] 	 = count($courses); 
$vfile="acad/sucoAcad";
if(isset($_GET['vfile'])){ pr($vfile); }
$this->view->render($data,$vfile);

}	/* fxn */



public function clsco(){
$dbo=PDBO;
$data['ucid']=$ucid=$_SESSION['user']['ucid'];
$data['sy']=$_SESSION['sy'];$data['qtr']=$_SESSION['qtr'];
$dbg=PDBG;$db=&$this->model->db;

$q="SELECT cr.*,cr.id AS crid,cr.name AS classroom FROM {$dbg}.05_classrooms AS cr
	WHERE cr.hcid = '$ucid'; ";
$sth=$db->querysoc($q);
$data['classrooms']=$classrooms=$sth->fetchAll();
$data['count']=count($classrooms); 
$this->view->render($data,'admins/clsco');



}	/* fxn */


public function locking($params=NULL){
$dbo=PDBO;
$dbg=PDBG;

$data['qtr'] = $qtr = isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$data['departments'] = $this->model->fetchRows("{$dbo}.`05_departments`");
$data['subjects'] = $this->model->fetchRows("{$dbo}.`05_subjects`");

$_SESSION['url'] = "acad/locking";
$this->view->render($data,'acad/locking');


}	/* fxn */



public function mca($params){
	$dbo=PDBO;
	require_once(SITE."functions/levels.php");
	require_once(SITE."functions/locks.php");
	$db	=&	$this->model->db;

	$level_id 		= $params[0];
	$data['home']	= $_SESSION['home'];

	$data['ssy'] = $ssy	= $_SESSION['sy'];
	$data['sy']	 = $sy 	= isset($params[1])? $params[1]: $ssy;
	$data['qtr'] = $qtr = isset($params[2])? $params[2]: $_SESSION['qtr'];
	$data['final']	 	= ($qtr>4)? true:false;
	$data['intfqtr']	= ($qtr==6)? 6:5;

	$dbg	= VCPREFIX.$sy.US.DBG;
		
	if($level_id){
		$data['crs']	= cq($db,$level_id,$cond=1,$dbg);		/* MiModel */
		$data['adv']	= aq($db,$level_id,$cond=1,$dbg);		/* MiModel */		
	}			

	$data['level'] = getLevel($db,$level_id,$dbg);	
	$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`",'id,code,name','id');
	
	$this->view->render($data,'mis/mca');

}	/* fxn */




public function unlockall($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/logs.php");
	$db	=&	$this->model->db;
	$dbg=PDBG;

$qtr = isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];

$q = "";
$q .= "UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q{$qtr}` = '0';  ";
$q .= "UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '0';  ";
// pr($q);exit;
$db->query($q);

$ucid = $_SESSION['ucid'];
$axn = $_SESSION['axn']['unlockall'];
$details = "Q{$qtr} unlockall";
$more['qtr'] = $qtr;

logThis($db,$ucid,$axn,$details,$more);	
$url = isset($_SESSION['url'])? $_SESSION['url']:$_SESSION['home'];
flashRedirect($url,"UnLocked All - Q{$qtr}");


}	/* fxn */




public function lockall($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/logs.php");
	require_once(SITE."functions/averager.php");
	$db	=&	$this->model->db;
	$dbg=PDBG;

$qtr = isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$today = $_SESSION['today'];

$q = "";
$q .= "UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q{$qtr}` = '1',`finalized_date_q{$qtr}` = '$today' 
	WHERE `is_finalized_q{$qtr}` <> '1';  ";
$q .= "UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '1',`finalized_date_q{$qtr}` = '$today'
	WHERE `is_finalized_q{$qtr}` <> '1';  ";

$db->query($q);		
$dbg = PDBG;$dbg = PDBG;
averager($db,$dbg,$qtr);

/* 2 logs */
$ucid = $_SESSION['ucid'];
$axn = $_SESSION['axn']['lockall'];
$details = "Q{$qtr} lockall";
$more['qtr'] = $qtr;
logThis($db,$ucid,$axn,$details,$more);	

$url = isset($_SESSION['url'])? $_SESSION['url']:$_SESSION['home'];
flashRedirect($url,"Locked All - Q{$qtr}");


}	/* fxn */



public function subcoor($params){
$hcid=$params[0];
$sub=$params[1];

$q="
	
";


}	/* fxn */



public function acst(){	
	$vfile="acad/acstAcad";vfile($vfile);
	$this->view->render($data=NULL,$vfile);
}


public function links(){
	$data=NULL;
	$sch=VCFOLDER;
	$one="linksAcad_{$sch}";$two="acad/linksAcad";
	$vfile=cview($one,$two);vfile($vfile);	
	$this->view->render($data,$vfile);
}	/* fxn */




} 	/* AcadController */
