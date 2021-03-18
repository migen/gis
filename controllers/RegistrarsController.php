<?php


Class RegistrarsController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	

	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(9,0),array(5,0),array(6,0),array(4,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		

	
}

public function beforeFilter(){ parent::beforeFilter();		}	



public function index($params=NULL){	
$dbo=PDBO;
	$db =& $this->model->db;	
	$home=$_SESSION['home'];
	if($_SESSION['srid']!=RREG) redirect($home);
		
	$data=$_SESSION['registrar']; 
	$data['user']=$_SESSION['user'];		
	$data['ssy']=$ssy=DBYR;
	$data['sqtr']=$sqtr= $_SESSION['qtr'];
	$data['sy']= $sy= isset($params[0])? $params[0]:DBYR;
	$data['qtr']= $qtr=isset($params[1])? $params[1]:$sqtr;
	$data['home']=$home;	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$data['levels']=$_SESSION['levels'];			
	if($sy!=DBYR){			
		$brid=$_SESSION['brid'];$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";
		$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);		
	} else {
		$data['classrooms']=$_SESSION['classrooms'];				
	}
	$vfile='registrars/indexRegistrars';vfile($vfile);
	$this->view->render($data,$vfile);	
}	/* fxn */



public function notes(){	
	$this->view->render(null,'registrars/notes');	
}	/* fxn */


public function profiles($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$crid  = isset($params[0])? $params[0] : null;
	$_SESSION['crid'] = $crid;
	$db=&$this->model->db;
	$data = $this->model->profiles($crid,PDBG);
	$data['classroom'] = getClassroomDetails($db,$crid);	
	$data['crid']=$crid;	
	$this->view->render($data,'registrars/profiles',$this->layout);
	

} 	/* fxn */



public function reset($params=NULL){
$dbo=PDBO;
	$ctlr 	= $params[0];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1] : $ssy;

	$dbg = VCPREFIX.$sy.US.DBG;
	$this->model->sessionizeRegistrar($dbg);	
	redirect($ctlr);
	
} /* reset */


public function qlr($params){	
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	

	$data['continuous']	  = $continuous	= isset($_GET['continuous'])? true:false;
	$data['level_id'] =	$level_id 		= $params[0];	
	$data['ssy']	  = $ssy	= $_SESSION['sy']; 
	$data['sqtr']	  = $sqtr	= $_SESSION['qtr']; 	
	$data['sy'] 	  =	$sy 	= 	isset($params[1])? $params[1] : $ssy;
	$data['qtr'] 	  =	$qtr 	= 	isset($params[2])? $params[2] : $sqtr;
	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$lrdomino = $_SESSION['settings']['lrdomino'];	
	$data['qf'] 	  =	$qf 	=  "q".$qtr;

if($qtr<5):	
	$q = " SELECT aq.`crid` AS `crid`,cr.`name` AS `cr` FROM {$dbg}.05_advisers_quarters AS `aq`
			INNER JOIN {$dbg}.05_classrooms AS `cr` ON aq.`crid` = cr.`id`
			INNER JOIN {$dbo}.`05_sections` AS `sec` ON cr.`section_id` = sec.`id`
		WHERE 	cr.`level_id` = '$level_id'
			AND aq.`is_finalized_q$qtr` <> '1'
			AND sec.`code` <> 'TMP'
			
	";
	$sth=$db->querysoc($q);
	$data['open_crids'] = $open_crids=$sth->fetchAll();
	$data['num_open'] = count($open_crids);
endif;
	
/* -------------------------------------------------------------------------------------------------------------------------------------	 */
	if(isset($_POST['submit'])){
		pr($_POST); exit;
		$rows = $_POST['rank'];		/* qualified for honors */			
		$q = "";
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summext SET `rank_level_$qf` = '".$row['qtr']."' WHERE `scid` = '".$row['scid']."' LIMIT 1; "; }	/* foreach */

		$rows = $_POST['nh'];		/* non-honors or regulars */			
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summext SET `rank_level_$qf`='".$row['qtr']."' WHERE `scid` = '".$row['scid']."' LIMIT 1; "; 
		}			
		$db->query($q);				
		$gotoQtr = ($qtr==4)? 5:$qtr;		
		$url = "registrars/qlr/$level_id/$sy/$gotoQtr";
		redirect($url);						
	}	/* post */
		
/* ------------------------ process page ------------------------------------------------------ */	

	$data['level']=getLevelDetails($db,$level_id);
	$fields = NULL;
	$limits = $_SESSION['settings']['limits_level_ranks'];
	
	if($qf == 'q5'){
		
		/* honors */
		if($lrdomino==1){ $honors = " AND ( sx.rank_classroom_q1 <> 0 ";
			for($i=2;$i<=4;$i++){ $honors .= " AND sx.rank_classroom_q$i <> 0 "; } $honors .= " ) ";
		} else { $honors = " AND sx.rank_classroom_$qf <> 0 "; }
		
		$limits = $_SESSION['settings']['limits_level_ranks'];
		$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$honors,$limits);	
		$data['num_students'] = count($data['students']);				

		/* non honors */
		$cond = ' AND ( sx.rank_classroom_q1 = 0 ';
		for($i=2;$i<5;$i++){ $cond .= " OR sx.rank_classroom_q$i = 0 "; }		
		$cond .= " ) ";

		$regulars = " $cond  ";
		$data['regulars'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$regulars,$limits);	
		$data['num_regulars'] = count($data['regulars']);				
		
	} else {	
		
		if($lrdomino==1){ $honors = " AND ( sx.rank_classroom_q1 <> 0 ";
			for($i=2;$i<=$qtr;$i++){ $honors .= " AND sx.rank_classroom_q$i <> 0 "; } $honors .= " ) ";
		} else { $honors = " AND sx.rank_classroom_$qf <> 0 "; }
				
		$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$honors,$limits);	
		$data['num_students'] = count($data['students']);				

		if($lrdomino==1){ $regulars = " AND ( sx.rank_classroom_q1 = 0 ";
			for($i=2;$i<=$qtr;$i++){ $regulars .= " OR sx.rank_classroom_q$i = 0 "; } $regulars .= " ) ";
		} else { $regulars = " AND sx.rank_classroom_$qf = 0 "; }
		
		$data['regulars'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$regulars,$limits);
		$data['num_regulars'] = count($data['regulars']);		
	}
	$data['qf']='q'.$qtr;
	$data['curr_qtr']=$_SESSION['qtr'];				
	$this->view->render($data,"registrars/qlr123");		

}	/* fxn */


public function qlra($params){	
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	
	$data['split']=$split=isset($_GET['split'])? true:false;
	$data['level_id']=$level_id=$params[0];	
	$data['ssy']=$ssy=$_SESSION['sy'];
	$data['sy']=$sy=$params[1];
	$data['qtr']=$qtr=$params[2];	
	$data['qf']=$qf="q".$qtr;
	$data['continuous']=$continuous=isset($_GET['continuous'])? true:false;
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$ad=isset($_GET['order'])? $_GET['order'] : $_SESSION['order'];
	$order=isset($_GET['sortby'])? $_GET['sortby'] : "sum.ave_$qf ";
	$data['get_name']=$get_name=$order;
	
	$order .= ' '.$ad;
	$data['order'] = $order;

if($qtr<5):	
	$q = " SELECT count(aq.id) AS num_open FROM {$dbg}.05_advisers_quarters AS aq
			INNER JOIN {$dbg}.05_classrooms AS cr ON aq.`crid` = cr.`id`
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.`section_id` = sec.`id`
		WHERE 	cr.`level_id` = '$level_id'
			AND aq.`is_finalized_q$qtr` <> '1'
			AND sec.`code` <> 'TMP'; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$data['num_open']=$row['num_open'];
endif;

$str_split 		= ($split)? "?split":NULL;
$_SESSION['url'] = "registrars/qlra/$level_id/$sy/$qtr{$str_split}";
	
/* ------------	 */
	if(isset($_POST['submit'])){
		// pr($_POST);exit;
		$rows = $_POST['rank'];		/* qualified for honors	 */
		$q = "";
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summext SET `rank_level_ave_$qf`='".$row['qtr']."' WHERE `scid`='".$row['scid']."' LIMIT 1; "; 
		}	/* foreach */
		
		// pr($q);exit;
		$db->query($q);				
		$url = "registrars/qlra/$level_id/$sy/$qtr";
		redirect($url);				
	}	/* post */
		
/* --- process page --- */	

	$data['level'] =getLevelDetails($db,$level_id);
	$fields = NULL;
	/* $limits = $_SESSION['settings']['limits_level_ranks']; */
	$limits = 500;
	$active=isset($_GET['active'])? true:false;
	if($qf == 'q5'){		
		$limits = 500;
$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order,$fields,$filter=NULL,$limits,$active);	
		$data['num_students'] = count($data['students']);				
		
	} else {			
$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order,$fields,NULL,$limits,$active);			
		$data['num_students'] = count($data['students']);						
	}
	
	$data['qf'] 		= 'q'.$qtr;
	$data['curr_qtr']	= $_SESSION['qtr'];	
	$view = ($split)? 'qlra_split':'qlra_tie';
	debug($view,"registrars QLRA vfile");
	$vfile="registrars/{$view}";vfile($vfile);
	$this->view->render($data,$vfile);
	
	
}	/* fxn */



private function setSYSettings($dbg,$new_sy,$old=0){
$dbo=PDBO;
	$old_sy = ($new_sy - 1);
	$sy  = ($old==1)? $old_sy : $new_sy;
	$qtr = ($old==1)? '4':'1';
	
	$q  = " UPDATE {$dbo}.`00_settings` SET `value` = '$sy' WHERE `name` = 'sy' LIMIT 1; ";
	$q .= " UPDATE {$dbo}.`00_settings` SET `value` = '$qtr' WHERE `name` = 'quarter' LIMIT 1; ";
	$q .= " UPDATE {$dbo}.`00_settings` SET `value` = '0' WHERE `name` = 'is_finalized_sectioning' LIMIT 1; ";
	$this->model->db->query($q);
}	/* fxn */



public function lbis($params){		/* best in subject per level */
$dbo=PDBO;
require_once(SITE."functions/details.php");
$data['lvl']=$lvl=isset($params[0])?$params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
$data['sqtr']	= $sqtr = $_SESSION['qtr'];
$data['fqtr']	= $fqtr	 = 'q'.$qtr;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$data['level']	= $level = getLevelDetails($db,$lvl);

$q = " SELECT distinct(sub.id) AS subject_id,sub.name AS subject
		FROM {$dbg}.05_courses AS crs
	INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
	INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
	WHERE cr.level_id = '$lvl' AND sub.crstype_id = '1'	
	ORDER BY crs.position LIMIT 500;";

$sth = $db->querysoc($q);
$data['subjects']=$subjects=$sth->fetchAll();
$data['num_subjects']=$num_subjects=count($data['subjects']);

$lbis = array();
for($i=0;$i<$num_subjects;$i++){
	$q = "
		SELECT a.section,a.student,sub.name AS subject,g.`$fqtr` AS grade
		FROM {$dbg}.50_grades AS g 
		INNER JOIN (
			SELECT cr.name AS classroom,sxn.name AS section,sum.scid,c.name AS student,c.code AS student_code
			FROM {$dbg}.05_summaries AS sum
				INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
				INNER JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
				INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
			WHERE cr.level_id = '$lvl' AND c.is_active = '1' AND sxn.code <> 'TMP'
		) AS a ON g.scid = a.scid		
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id		
		WHERE 	sub.id = '".$subjects[$i]['subject_id']."' ORDER BY grade DESC LIMIT 1;";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$lbis[] = $row;
}

$data['lbis']=&$lbis;

$this->view->render($data,'registrars/lbis');

}	/* fxn */

public function xcheckLogin($params=null){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	$login = $_POST['login'];
	$q = " SELECT id,code,account,name FROM {$dbo}.`00_contacts` WHERE `code` = '$login' LIMIT 1; ";	
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();

	$_SESSION['q'] = $q;
	echo json_encode($row);

}	/* fxn */



public function nextCode($params=NULL){
$dbo=PDBO;
	$used_code = $params[0];
	$parts = explode('-',$used_code);
	$last_num = array_pop($parts);
	$next_num = $last_num+1;
	pr($next_num);

}	/* fxn */


  

public function xeditAts(){
$dbo=PDBO;
	$ats 	= $_POST['ats'];
	$active = $_POST['active'];
	$male 	= $_POST['male'];
	$cid 	= $_POST['cid'];

	$q  = " UPDATE {$dbo}.`00_contacts` SET `is_male` = '$male',`is_active` = '$active',`attschema_id` = '$ats' WHERE `id` = '$cid' LIMIT 1;   ";
	$_SESSION['q'] = $q;
	$this->model->db->query($q);

}	/* fxn */
  

/* for bonuses individual syncGrades like mis/syncGrades */ 
public function editStudentGrades($params=NULL){		
	$dbo=PDBO;
	require_once(SITE."functions/fine.php");
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/editStudentGrades.php");
	$db =& $this->model->db;

/* from ccr */ 
	$data['ssy'] = $ssy = $_SESSION['sy'];
	$data['sqtr'] = $sqtr = $_SESSION['qtr'];

	$data['home'] = $home = $_SESSION['home'];
	$data['scid'] = $scid = isset($params[0])? $params[0]:false;
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$data['qtr'] = $qtr = isset($params[2])? $params[2]:$sqtr;

	$data['current']	= $current = ($sy==$ssy)? true:false;
	$dbyr 	= $sy.US;	
	$dbg  = VCPREFIX.$dbyr.DBG;
	$dbg  = VCPREFIX.$dbyr.DBG;

		

if($scid){

	$data['student'] = $student	= student($db,$dbg,$sy,$scid);
	$data['crid']=$crid=$student['crid'];	
	$_SESSION['url'] = "mis/editStudentGrades/$scid/$sy/$qtr";		
	$srid 	 = $_SESSION['user']['role_id']; 	
		
	if(isset($_POST['tally'])){
		/* 1 - edit grades */
		$rows = $_POST['grades'];
		$q = "";
		foreach($rows AS $row){ $q .= " UPDATE {$dbg}.`50_grades` SET 
			`q1` = '".$row['q1']."',`q2` = '".$row['q2']."',`q3` = '".$row['q3']."',
			`q4` = '".$row['q4']."',`q5` = '".$row['q5']."',`q6` = '".$row['q6']."'
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; }
		$db->query($q);		
		
	}	/* post-edit */
		
	if(isset($_POST['edit'])){
		/* 1 - edit grades */
		$rows = $_POST['grades'];
		$q = "";		
		foreach($rows AS $row){ $q .= " UPDATE {$dbg}.`50_grades` SET 
			`dg1` = '".$row['dg1']."',`dg2` = '".$row['dg2']."',`dg3` = '".$row['dg3']."',`dg4` = '".$row['dg4']."',
			`dg5` = '".$row['dg5']."',`dg6` = '".$row['dg6']."' 				
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; }				
		$db->query($q);						

		/* 2 - fineSummariesAttendance */
		fineSumAtt($db,$dbg,$sy,$scid,$crid);
	
		/* 3 - open classroom */
		unlockClassroom($db,$crid,$qtr,$dbg);
				
		/* 4 - redirect */		
		$url = "summarizers/student/$scid/$sy/$qtr";		
		redirect($url);
		exit;		
	}	/* post-edit */
	
	if(isset($_POST['add'])){
		/* 1 - add grades */
		$rows = $_POST['grades'];
		$q = "INSERT INTO {$dbg}.`50_grades` (`scid`,`course_id`,`q$qtr`) VALUES";
		foreach($rows AS $row){ $q .= "  ('".$scid."','".$row['crsid']."','".$row['grade']."'),"; }
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);				
		$url = "registrars/editStudentGrades/$scid/$sy/$qtr";
		redirect($url);		
	}	/* post-add */
	
	
/* ------------- data -------------------------------------------- */		
	$data['cr'] 			= getClassroomDetails($db,$crid,$dbg);
	$data['is_locked'] 		= $data['cr']['is_finalized_q'.$qtr];
	$data['courses'] 	 	= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter=null);	
	$data['num_courses']	= count($data['courses']);

	$all=(isset($_GET['all']))? true:false;
	$data['grades'] = editStudentGrades($db,$dbg,$crid,$scid,$sy,$qtr,$ctype=1,$agg=1,$all);		
	$data['course_ids']  = buildArray($data['courses'],'course_id');	
	$data['num_grades']	= count($data['grades']);
	$data['gids'] = buildArray($data['grades'],'course_id');
	$data['ratings'] = getRatings($db,'1',$data['student']['department_id']);				
}	/* scid */

		

			
	$vfile='registrars/editStudentGrades';vfile($vfile);
	$this->view->render($data,$vfile);

}	 /* fxn */

  

public function status($params){
$dbo=PDBO;
$code = $params[0];
$data['ssy'] = $ssy = $_SESSION['sy'];
$data['sy']	 = $sy  = isset($params[1])? $params[1]:$ssy;
$data['current'] = $current = ($sy==$ssy)? true:false;

$dbg = ($current)? DBM:$sy.US.DBG;
$data['home']	= $home = $_SESSION['home'];

if(isset($_POST['submit'])){
	$q = " UPDATE {$dbo}.`00_contacts` SET `is_active` = '".$_POST['status']."' WHERE `id` = '".$_POST['cid']."' LIMIT 1; ";
	$this->model->db->query($q);	
}	/* fxn */

if(isset($_POST['search'])){
	$url = "registrars/status/".$_POST['code'];
	redirect($url);
	
}	

/* ------------- PROCESS ----------------------------------------------------------- */
$with_chinese = $_SESSION['settings']['with_chinese'];

$q = " SELECT  ";
$q .= ($with_chinese)? " c.chinese_name," : NULL;
$q .= " c.* FROM {$dbo}.`00_contacts` AS c ";
$q .= ($with_chinese)? " LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id " : NULL;

$q .= " WHERE c.`code` = '$code' LIMIT 1; ";

$data['with_chinese'] = $with_chinese;
$sth = $this->model->db->querysoc($q);
$data['contact'] = $sth->fetch();
$this->view->render($data,'registrars/status');


}	/* fxn */



public function xeditSectioning($params){	/* former mis classpool xeditStudCls before apr8 */
$dbo=PDBO;
	/*  1-students,2-enrollments,3-summaries */
	$scid 	= $params[0];
	$ssy	= $_SESSION['sy'];
	$sy		= $params[1];
	
	// $dbyr 	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;	
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$row 	= $_POST;
	
	/* 1-contacts */	
	$q .= " UPDATE {$dbo}.`00_contacts` SET 
				`is_male` 				= '".$row['male']."',
				`is_active` 			= '".$row['active']."',
				`is_cleared` 			= '".$row['cleared']."',
				`crid` 			= '".$row['crid']."',
				`sy` 			= '".$row['studsy']."',
				`attschema_id` 			= '".$row['attsch']."'
			WHERE `id` = '".$scid."' LIMIT 1;
	";	
		
	/* 2-summaries */
	$q .= "
		UPDATE {$dbg}.05_summaries 
		SET `crid` = '".$row['crid']."',`acid` = '".$row['acid']."'
		WHERE `scid` = '".$scid."' LIMIT 1;	
	";
	
	$_SESSION['q'] = $q;		
	return $this->model->db->query($q);

}	/* fxn */




public function classlistManager($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classyear.php");
	$db =& $this->model->db;
	
	$data['crid']	= $crid = $params[0];	
	$data['ssy']	= $ssy 	= $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $_SESSION['home'];
		
	// $dbyr = ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;	
	$dbg  = VCPREFIX.$dbyr.DBG;	
	$dbg  = VCPREFIX.$dbyr.DBG;	
	

	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		// pr($_POST['rows']); exit;
		$q = $this->deleteStudents($ids);
		$this->model->db->query($q);
		Session::set('message','Purged Students Successfully!');
		$url = "registrars/classlistManager/$crid/$sy";
		redirect($url);		
		exit;
	}
	if(isset($_POST['save'])){
		pr($_POST);
		exit;
	}
				
$data['classroom']		= getClassroomDetails($db,$crid,$dbg);	
$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
$data['attschemas']		= $this->model->fetchRows("{$dbg}.05_attendance_schemas","*");


$fields=null;$filter=null;$limits=null;$active=false;
$order="c.is_male DESC,c.name";
$data['students']=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields="c.attschema_id,",$filter,$limits,$active);	


	$data['num_students']	= count($data['students']);		
	$this->view->render($data,'registrars/classlistManager');	



}	/* fxn */



	
public function sxns($params=NULL){
$dbo=PDBO;
$data['page']	= $page	= isset($params[0])? $params[0]:1;
$data['limit']	= $limit	= isset($params[1])? $params[1]:10;
$data['offset']	= $offset = ($page-1)*$limit;
$data['cond']	= $cond 	= isset($_GET['condition'])? $_GET['condition']:"sxn.code='TMP'";
$dbg=PDBG;

if(isset($_GET['submit'])){
	$page  = $_GET['page'];
	$limit = $_GET['limit'];
	$url = "registrars/sxns/$page/$limit?condition=$cond";
	redirect($url);
}


$q = "
	SELECT
		c.id AS scid,c.name AS student,c.is_active,c.`sy` AS cyear,c.is_cleared,c.code,c.account,c.is_male,
		l.name AS level,
		sxn.name AS section,
		c.crid AS studcrid,c.`sy` AS consy,
		sum.crid AS sumcrid	
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		LEFT JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
	WHERE $cond
	ORDER BY cr.level_id,cr.section_id,c.is_male,c.name 
	LIMIT $limit OFFSET $offset;	
";
// pr($q);exit;
$data['q'] = $q;
$sth = $this->model->db->querysoc($q);
$data['students'] = $sth->fetchAll();
$data['count'] = count($data['students']);

$this->view->render($data,'registrars/sxns');


}	/* fxn */






public function attendanceEmployeesIndex($params=NULL){
$dbo=PDBO;
$data['home'] = $home = $_SESSION['home'];
$data['sy']	  = DBYR;
require_once(SITE."functions/employees.php");
$db=&$this->model->db;$dbg=PDBG;
$fields = NULL;
$filters="AND c.is_active = 1";
$data['employees'] = employees($db,$dbg,$fields,$filters);
$data['count']	= count($data['employees']);
$data['months'] = $this->model->fetchRows(DBO.'.months','*','id');
$sqtr = $_SESSION['qtr'];
$data['mq'] = $this->model->fetchRows("{$dbo}.`05_months_quarters`",'*','id','WHERE `quarter` = '.$sqtr);
$this->view->render($data,'registrars/attendanceEmployeesIndex');


}	/* fxn */



public function attdem($params=NULL){
$dbo=PDBO;
$data['date']	= $date = isset($params[0])? $params[0]:$_SESSION['today'];
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$q = "SELECT 
		c.parent_id pcid,b.*,c.name AS contact
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN (
			SELECT att.* FROM {$dbg}.06_attendance_employees_logs AS att WHERE att.date = '$date'
		) AS b ON b.contact_id = c.id
	WHERE c.role_id <> '".RSTUD."' AND c.is_active = '1' AND c.parent_id <> '1'	AND (c.id=c.parent_id) 	
	ORDER BY c.name;";
debug($q,"registrarsCtlr: attdem ");
$sth = $this->model->db->querysoc($q);
$data['attd'] = $sth->fetchAll();
$data['count'] = count($data['attd']);
$this->view->render($data,'registrars/attdem');

}	/* fxn */



public function editClassroomAdviser($params){
$dbo=PDBO;

require_once(SITE."functions/details.php");
$db=&$this->model->db;$dbg=PDBG;
$data['crid'] = $crid = $params[0];
$data['classroom']	= getClassroomDetails($db,$crid,$dbg);	
$where = "WHERE role_id = ".RTEAC." AND is_active = 1 ";
$data['teachers']	= fetchRows($db,DBO.'.contacts','id,name',$order='name',$where);
$where = "WHERE role_id 	= ".RACAD." AND is_active = 1 ";
$data['coordinators']	= fetchRows($db,DBO.'.contacts','id,name',$order='name',$where);

if(isset($_POST['submit'])){
	$row = $_POST;
	$q = "UPDATE $dbg.05_classrooms SET `acid` = ".$row['acid'].",`hcid` = ".$row['hcid']." WHERE `id` = '$crid' LIMIT 1;";
	$db->query($q);
	$url = $_SESSION['url'];
	redirect($url);
	exit;
}	/* post */


$this->view->render($data,'registrars/editClassroomAdviser');

}	/* fxn */




public function unsetter($params=NULL){
$dbo=PDBO;
	$key = $params[0];
	$_SESSION[$key] = NULL;	
	unset($_SESSION[$key]);
	$url = $_SESSION['home'];
	flashRedirect($url,"Unset $key.");
}	/* fxn */

public function fetcher($params=NULL){
$dbo=PDBO;
	$key = $params[0];

	$dbparts = explode('.',$key);
	$dbcode = (isset($dbparts[1]))? $dbparts[0]:'dbm';
	$table = (isset($dbparts[1]))? $dbparts[1]:$dbparts[0];
	if($dbcode=='dbm'){
		$dbtable = PDBG.'.'.$table;	
	} else {
		$dbtable = PDBO.'.'.$table;	
	}

	$_SESSION[$table] = $this->model->fetchRows($dbtable,'id,name');
	$url = $_SESSION['home'];
	flashRedirect($url,"Refetched $table.");
	
}	/* fxn */


public function classroom($params=null){
$dbo=PDBO;
$data['crid'] = $crid = $params[0];
$sy = isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;$dbg = VCPREFIX.$sy.US.DBG;
$q = "SELECT c.id AS ucid,c.parent_id AS pcid,c.code,c.account,c.pass,		
		ctp.ctp,c.name AS adviser,cr.name AS classroom,cr.id AS crid,
		ctp.contact_id AS ctpucid,p.contact_id AS profpcid,ph.contact_id AS photopcid,pc.name AS pcname
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN ".DBP.".photos AS ph ON ph.contact_id = c.parent_id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.parent_id
	WHERE cr.id = '$crid' LIMIT 1;";
$sth = $this->model->db->querysoc($q);
$data['row'] = $row = $sth->fetch();

$sync=false;
$q = "";
if(empty($row['adviser'])) { $q .= "UPDATE {$dbo}.`00_contacts` SET `name` = '".$row['pcname']."' WHERE `id` = '".$row['ucid']."';"; $sync=true; }
if(empty($row['ctpucid'])) { $q .= "INSERT INTO {$dbo}.`00_ctp`(`contact_id`) VALUES ('".$row['ucid']."');"; $sync=true; }
if(empty($row['profpcid'])) { $q .= "INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('".$row['pcid']."');"; $sync=true; }
if(empty($row['photopcid'])) { $q .= "INSERT INTO ".PDBP.".photos(`contact_id`) VALUES ('".$row['pcid']."');"; $sync=true; }
$url = "registrars/classroom/$crid";
if(isset($_GET['debug'])){ pr($q); }
if($sync){ 
	$db->query($q);
	echo "<h3 class='brown' >Please refresh page.</h3>";
}


$this->view->render($data,'registrars/classroomAdviser');

}	/* fxn */




public function filter($params=NULL){ 
$dbo=PDBO;
	require_once(SITE.'functions/registrarsFxn.php');
	$data['home']	= $_SESSION['home'];	
	$db=&$this->model->db;
	
if(isset($_GET['filter'])){
	$post = $_GET;
	$cond = NULL;
	$cond .= "";
	$sy=!empty($post['sy'])? $post['sy']:DBYR;
	if (!empty($post['lvlid'])){ $cond .= " AND cr.level_id = '".$post['lvlid']."'"; }				
	if (!empty($post['crid'])){ $cond .= " AND cr.id = '".$post['crid']."'"; }				
		
	$sort   = (isset($post['sort']))?$post['sort']:'c.name';
	$order  = (isset($post['order']))?$post['order']:'ASC';
	
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
		
	$data['rows'] = filterStudents($db,$dbg,$cond,$sort,$order);
	$data['count'] = count($data['rows']);
		
			
} /* get */

	$data['classrooms'] = $_SESSION['classrooms'];	
	$data['levels'] = $_SESSION['levels'];		
	$this->view->render($data,'registrars/filter');	

}	/* fxn */


public function setting($params=null){
$dbo=PDBO;
$setting=isset($params[0])? $params[0]:false;
if(!$setting){ echo "No setting parameter."; exit; }
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

if(isset($_POST['submit'])){
	$post['value']=$_POST['value'];
	$id=$_POST['id'];
	$db->update("{$dbo}.`00_settings`",$post,"id='$id'");	
	flashRedirect('index',"Setting updated.");
}	/* post */


$q="SELECT * FROM {$dbo}.`00_settings` WHERE name='$setting' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

$this->view->render($data,'registrars/settingRegistrars');

}	/* fxn */






} 	/* RegistrarsController */
