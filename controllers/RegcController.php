<?php


Class RegController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	

	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(9,0),array(5,0),array(6,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		

	
}

public function beforeFilter(){ parent::beforeFilter();		}	



public function index($params=NULL){	
$dbo=PDBO;

$db =& $this->model->db;$dbg=PDBG;
$home=$_SESSION['home'];	
$srid=$_SESSION['srid'];
$allowed=array(RMIS,RREG);
if(!in_array($srid,$allowed)){ flashRedirect(); }
// $data=$_SESSION['registrar']; 
$data['user']=$_SESSION['user'];		
$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
$data['qtr']=$qtr=isset($params[1])?$params[1]:$_SESSION['qtr'];
$data['home']=$home;	
	
if(!isset($_SESSION['roles'])){ $_SESSION['roles'] = fetchRows($db,DBO.'.`00_roles`'); } 
$data['roles'] 	= $_SESSION['roles'];	
if(!isset($_SESSION['classrooms'])){ $_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name,acid AS acid","level_id,name"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];		
if(!isset($_SESSION['levels'])){ $_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,name","id"); 	 } 
$data['levels'] = $_SESSION['levels'];		
$vfile="reg/indexReg";
$this->view->render($data,$vfile);	

}	/* fxn */



public function notes(){	
	$this->view->render(null,'registrars/notes');	
}	/* fxn */



public function level($params){
$dbo=PDBO;
	$level_id  = isset($params[0])? $params[0] : null;
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1] : $ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	if(!in_array($level_id,$_SESSION['levels'])) redirect('registrars');	
	$data = $this->model->level($level_id,$dbg);	
	$this->view->render($data,'registrars/level');		
}	/* fxn */


public function units($params){
$dbo=PDBO;
	// echo 'p';
	$crid  = isset($params[0])? $params[0] : null;	
	$data = $this->model->units($crid);
	$this->view->render($data,'registrars/units');
}	/* fxn */


private function getLevelsByDepartment($dept_id,$dbg=PDBG){
$dbo=PDBO;
	$q = " SELECT * FROM {$dbo}.`05_levels` WHERE `department_id` = '$dept_id' ";
	$sth = $this->model->db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


private function getAllSections($dbg=PDBG){
$dbo=PDBO;
	$q = " SELECT * FROM {$dbo}.`05_sections` ";
	$sth = $this->model->db->querysoc($q);
	return $sth->fetchAll();
}


private function getLevelGroup($x){
	switch($x):
		case (($x > 0) && ($x <= 6)):
			return 'knp123'; break;
		case (($x > 6) && ($x <= 9)):
			return '456'; break;
		case (($x > 9) && ($x <= 11)):
			return '78'; break;
		case (($x > 11) && ($x <= 13)):
			return '90'; break;
			default:
			return 'bad number'; break; 
	endswitch;
}


private function getLevelSection($crid,$dbg=PDBG){
$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.05_classrooms WHERE `id` = '$crid' LIMIT 1; ";
	$sth	= $this->model->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


public function getSections($params=NULL){
$dbo=PDBO;
	$level_id = $_POST['level'];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[0])? $params[0]:$ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;
	$rows = $this->model->getSections($level_id,$dbg);	
	$_SESSION['level'] = $level_id;
	echo json_encode($rows);
}	/* fxn */


public function getSubjects($params=NULL){
$dbo=PDBO;
	$level_id = $_POST['level'];
	include_once(SITE.'views/elements/params_sq.php');	
	$ctype = 1;
	$rows = $this->model->getSubjects($dbg,$level_id,$ctype);	
	$_SESSION['level'] = $level_id;
	echo json_encode($rows);
}	/* fxn */

/* --------------------------------------------------------------------------------------------------------------- */


public function editGrades($ids){		/* test if still working */
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");

	if($_SESSION['user']['role_id']!=RREG){ $this->flashRedirect('index'); }
		
	if(isset($_POST['submit'])){
		$rows 		= $_POST['data']['Grade'];
		$course_id 	= $_POST['data']['course_id'];
		
		$data['course'] 	= getCourseDetails($db,$course_id);	
		$crsClass	= classifyCourse($data['course']);
		$ratings = $data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
			
		$q = "";
		foreach($rows as $row){			/* pr($row); */
			$sy 	= $row['sy'];
			$scid 	= $row['scid'];
			$gid 	= $row['gid'];
			$sumid 	= $row['sumid'];
		
			/* 1 - rating (tq1 to tq4,final) */
			$dg1 	= rating($row['tq1'],$ratings);	
			$dg2 	= rating($row['tq2'],$ratings);	
			$dg3 	= rating($row['tq3'],$ratings);	
			$dg4 	= rating($row['tq4'],$ratings);	
			$dgf 	= rating($row['q5'],$ratings);	

			/* 2 - update gid : bq1 to bq4,dg1 to dg4,final,dg5 */
			$q = " 
				UPDATE {$dbg}.50_grades SET 
					
				WHERE `id` = '".$gid."' LIMIT 1;					
			";
			pr($q); exit;
			
			$this->model->db->query($q);							

			/* 3 - get all qtrs genave using mysql AVG fxn */
			$q = "
				SELECT 
					a.scid,avg(a.q1) AS aq1,avg(a.q2) AS aq2,avg(a.q3) AS aq3,avg(a.q4) AS aq4,avg(a.final) AS afg 								
				FROM (
					SELECT 
						g.scid AS scid,
						crs.id AS crsid,crs.name AS course,
						g.q1,g.q2,g.q3,g.q4,g.q5
					FROM {$dbg}.50_grades AS g
						LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
					WHERE 							
						g.`crstype_id` 	= '1'
					AND crs.`supsubject_id` 	= '0'
					AND g.`scid` = '$scid'
					ORDER BY crs.id														
				) AS a			
			";
			$sth = $this->model->db->querysoc($q);
			$row = $sth->fetch();

			/* 4 - summaries rating dg */
			$adg1 	= rating($row['aq1'],$ratings);	
			$adg2 	= rating($row['aq2'],$ratings);	
			$adg3 	= rating($row['aq3'],$ratings);	
			$adg4 	= rating($row['aq4'],$ratings);	
			$adgf 	= rating($row['afg'],$ratings);	
			
			$q = "
				UPDATE {$dbg}.05_summaries SET
					`ave_q1` = '".$row['aq1']."',`ave_q2` = '".$row['aq2']."',`ave_q3` = '".$row['aq3']."',
					`ave_q4` = '".$row['aq4']."',`ave_q5` = '".$row['afg']."', 
					`ave_dg1` = '$adg1',`ave_dg2` = '$adg2',`ave_dg3` = '$adg3',`ave_dg4` = '$adg4',`ave_dg5` = '$adgf' 
				WHERE `id` = '$sumid' LIMIT 1;
			";			
			// pr($q);
			$this->model->db->query($q);				
		
		} 	/* foreach	 */
		
		$url = 'averages/course/'.$_SESSION['course']['course_id'].DS.$_SESSION['sy'].'/4';
		redirect($url);		
		exit;
	}	/* post-submit */
	
	foreach($ids as $id){ $data['Grade'][] = $this->model->grade($id); }			
	$this->view->render($data,'registrars/editGrades');		
	
}	/* fxn */



public function profiles($params){
$dbo=PDBO;
	$crid  = isset($params[0])? $params[0] : null;
	$_SESSION['crid'] = $crid;
	$data = $this->model->profiles($crid);
	$this->view->render($data,'registrars/profiles',$this->layout);
	

} 	/* fxn */



public function assess(){
$dbo=PDBO;
	$studcode = $_POST['studcode'];
	$q = " SELECT id FROM {$dbo}.`00_contacts` 
			WHERE `code` = '$studcode' LIMIT 1; ";
	
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();

	echo json_encode($row);

}	/* fxn */


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
	$db =& $this->model->db;

	$data['continuous']	  = $continuous	= isset($_GET['continuous'])? true:false;
	$data['level_id'] =	$level_id 		= $params[0];	
	$data['ssy']	  = $ssy	= $_SESSION['sy']; 
	$data['sqtr']	  = $sqtr	= $_SESSION['qtr']; 
	
	$data['sy'] 	  =	$sy 	= 	isset($params[1])? $params[1] : $ssy;
	$data['qtr'] 	  =	$qtr 	= 	isset($params[2])? $params[2] : $sqtr;
	
	$dbg  	= VCPREFIX.$sy.US.DBG;
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
	// pr($q);exit;
	$sth 				= $this->model->db->querysoc($q);
	$data['open_crids'] = $open_crids 	= $sth->fetchAll();

	$data['num_open'] = count($open_crids);

endif;
	
/* -------------------------------------------------------------------------------------------------------------------------------------	 */
	if(isset($_POST['submit'])){
		// pr($_POST); exit;
		$rows = $_POST['rank'];		/* qualified for honors */			
		$q = "";
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summaries SET `rank_level_$qf` = '".$row['qtr']."' WHERE `id` = '".$row['sumid']."' LIMIT 1; "; }	/* foreach */

		$rows = $_POST['nh'];		/* non-honors or regulars */			
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summaries SET `rank_level_$qf` = '".$row['qtr']."' WHERE `id` = '".$row['sumid']."' LIMIT 1; "; }	
		
		// pr($q); exit;		
		$this->model->db->query($q);				
		$gotoQtr = ($qtr==4)? 5:$qtr;
		
		$url = "registrars/qlr/$level_id/$sy/$gotoQtr";
		redirect($url);						
	}	/* post */
		
/* ------------------------ process page ------------------------------------------------------ */	

	$data['level']  = getLevelDetails($db,$level_id);
	$fields = NULL;
	$limits = $_SESSION['settings']['limits_level_ranks'];
	
	if($qf == 'q5'){
		
		/* honors */
		if($lrdomino==1){ $honors = " AND ( sum.rank_classroom_q1 <> 0 ";
			for($i=2;$i<=4;$i++){ $honors .= " AND sum.rank_classroom_q$i <> 0 "; } $honors .= " ) ";
		} else { $honors = " AND sum.rank_classroom_$qf <> 0 "; }
		
		$limits = $_SESSION['settings']['limits_level_ranks'];
		$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$honors,$limits);	
		$data['num_students'] = count($data['students']);				

		/* non honors */
		$cond = ' AND ( sum.rank_classroom_q1 = 0 ';
		for($i=2;$i<5;$i++){ $cond .= " OR sum.rank_classroom_q$i = 0 "; }		
		$cond .= " ) ";

		$regulars = " $cond  ";
		$data['regulars'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$regulars,$limits);	
		$data['num_regulars'] = count($data['regulars']);				
		
	} else {	
		
		if($lrdomino==1){ $honors = " AND ( sum.rank_classroom_q1 <> 0 ";
			for($i=2;$i<=$qtr;$i++){ $honors .= " AND sum.rank_classroom_q$i <> 0 "; } $honors .= " ) ";
		} else { $honors = " AND sum.rank_classroom_$qf <> 0 "; }
				
		$data['students'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$honors,$limits);	
		$data['num_students'] = count($data['students']);				

		if($lrdomino==1){ $regulars = " AND ( sum.rank_classroom_q1 = 0 ";
			for($i=2;$i<=$qtr;$i++){ $regulars .= " OR sum.rank_classroom_q$i = 0 "; } $regulars .= " ) ";
		} else { $regulars = " AND sum.rank_classroom_$qf = 0 "; }
		// echo "regulars: $regulars <br />";

		
		// $regulars = " AND sum.rank_classroom_$qf = 0 ";
		$data['regulars'] = $this->model->levelyear($dbg,$sy,$level_id,$male=2,$order="sum.ave_$qf DESC",$fields,$filter=$regulars,$limits);	
		
		$data['num_regulars'] = count($data['regulars']);		
	}
	
	$data['qf'] 		=  'q'.$qtr;
	$data['curr_qtr']	=	$_SESSION['qtr'];
				
	$this->view->render($data,"registrars/qlr123");		

}	/* fxn */


public function qlra($params){	
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;
	$data['split']  = $split = isset($_GET['split'])? true:false;

	$data['level_id'] =	$level_id 		= $params[0];	
	$data['ssy']	  = $ssy	= $_SESSION['sy'];
	$data['sy'] 	  =	$sy 	= 	$params[1];
	$data['qtr'] 	  =	$qtr 	=   $params[2];	
	$data['qf'] 	  =	$qf 	= 	"q".$qtr;
	$data['continuous']	  = $continuous	= isset($_GET['continuous'])? true:false;
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$ad		= isset($_GET['order'])? $_GET['order'] : $_SESSION['order'];
	$order 	= isset($_GET['sortby'])? $_GET['sortby'] : "sum.ave_$qf ";
	$data['get_name'] = $get_name = $order;
	
	$order .= ' '.$ad;
	$data['order'] = $order;
	// pr($_SESSION);

if($qtr<5):	
	$q = " SELECT count(aq.id) AS num_open FROM {$dbg}.05_advisers_quarters AS aq
			INNER JOIN {$dbg}.05_classrooms AS cr ON aq.`crid` = cr.`id`
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.`section_id` = sec.`id`
		WHERE 	cr.`level_id` = '$level_id'
			AND aq.`is_finalized_q$qtr` <> '1'
			AND sec.`code` <> 'TMP'
			
	";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();

	$data['num_open'] = $row['num_open'];
endif;

$str_split 		= ($split)? "?split":NULL;
$_SESSION['url'] = "registrars/qlra/$level_id/$sy/$qtr{$str_split}";
	
/* -------------------------------------------------------------------------------------------------------------------------------------	 */
	if(isset($_POST['submit'])){
		$rows = $_POST['rank'];		/* qualified for honors	 */
		// pr($_POST);
		$q = "";
		foreach($rows AS $row){ 
			$q .= " UPDATE {$dbg}.05_summaries SET `rank_level_ave_$qf` = '".$row['qtr']."' WHERE `id` = '".$row['sumid']."' LIMIT 1; "; 
		}	/* foreach */
		
		// pr($q);exit;
		$this->model->db->query($q);				
		$url = "registrars/qlra/$level_id/$sy/$qtr";
		redirect($url);				
	}	/* post */
		
/* ------------------------ process page ------------------------------------------------------------------------------------ */	

	$data['level']  = getLevelDetails($db,$level_id);
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
	$this->view->render($data,"registrars/{$view}");
	
	
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


private function switchSYClassroomsCourses($dbg=PDBG,$sy,$old=1){
$dbo=PDBO;
	
	$q  = " UPDATE {$dbg}.05_courses_quarters SET 
		`is_finalized_q1` = '$old',`finalized_date_q1` = '0000-00-00',`is_finalized_q2` = '$old',`finalized_date_q2` = '0000-00-00',    
		`is_finalized_q3` = '$old',`finalized_date_q3` = '0000-00-00',`is_finalized_q4` = '$old',`finalized_date_q4` = '0000-00-00' ;		
	";
	$q .= " UPDATE {$dbg}.05_advisers_quarters SET 
		`is_finalized_q1` = '$old',`finalized_date_q1` = '0000-00-00',`is_finalized_q2` = '$old',`finalized_date_q2` = '0000-00-00',    
		`is_finalized_q3` = '$old',`finalized_date_q3` = '0000-00-00',`is_finalized_q4` = '$old',`finalized_date_q4` = '0000-00-00' ;		
	";
	$q .= " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '$old',`init_grades_sy` = '$sy'; ";
	$this->model->db->query($q);


}	/* fxn */
	

private function truncATL($dbg=PDBG){
$dbo=PDBO;
	$q  = " TRUNCATE {$dbg}.05_attendance_logs; ";
	Session::set('message','Attendance Logs and Daily Truncated.');
	$this->model->db->query($q);
}	/* fxn */



public function openSectioning($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	$q = " UPDATE {$dbo}.`00_settings` SET `value` = '0' WHERE `name` = 'is_finalized_sectioning' LIMIT 1; ";
	$this->model->db->query($q);
	$this->model->sessionizeRegistrar($dbg);
	redirect('registrars/dashboard');
}	/* fxn */

public function lockSectioning($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbo}.`00_settings` SET `value` = '1' WHERE `name` = 'is_finalized_sectioning' LIMIT 1; ";
	$this->model->db->query($q);
	$this->model->sessionizeRegistrar($dbg);
	redirect('registrars/dashboard');
}	/* fxn */



public function lsr($params){
$dbo=PDBO;

require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['level_id']	= $level_id 		= $params[0];
$data['subject_id']	= $subject_id 		= $params[1];
$data['ssy']		= $ssy				= $_SESSION['sy'];
$data['sy']			= $sy		 		= $params[2];
$data['qtr']		= $qtr	 			= $params[3];
$dbg  = VCPREFIX.$sy.US.DBG;
$data['fqtr']=$fqtr='q'.$qtr;

$limits = 500;
/* $limits = $_SESSION['settings']['limits_levelsubject_ranks']; */

$q = "
	SELECT 
		c.id AS scid,c.code AS student_code,c.name AS student,g.`$fqtr` AS grade,sec.name AS section
	FROM {$dbg}.50_grades AS g
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id 		= crs.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id 	= sec.id
		INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid 	= c.id
	WHERE 
			cr.level_id		= '$level_id'
		AND	crs.subject_id	= '$subject_id'
	ORDER BY g.`$fqtr` DESC
	LIMIT $limits
";
$sth = $this->model->db->querysoc($q);
$data['grades']	= $sth->fetchAll();


$data['level']		= getLevelDetails($db,$level_id,$dbg);
$data['subject']	= getSubjectDetails($db,$subject_id,$dbg);

$this->view->render($data,'registrars/lsr');

}	/* fxn */


public function inactiveStudents($params){
$dbo=PDBO;

include_once(SITE.'views/elements/params_sq.php');

$q = " SELECT 
			c.id AS scid,c.code AS student_code,c.name AS student,c.remarks,c.is_active
	FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
	WHERE 
			c.`is_active` = '0'
		AND c.`sy` = '$sy';
";

$data['sy'] = $sy;
$sth = $this->model->db->querysoc($q);
$data['dropouts'] = $sth->fetchAll();

$this->view->render($data,'registrars/inactiveStudents');

}	/* fxn */



public function lbis($params){		/* best in subject per level */
$dbo=PDBO;

require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['lvl']	= $lvl 	= $params[0];
$ssy			= $_SESSION['sy'];
$data['sy']		= $sy 	= isset($params[1])? $params[1]:$ssy;
$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : '5';
$data['sqtr']	= $sqtr = $_SESSION['qtr'];

$data['fqtr']	= $fqtr	 = 'q'.$qtr;
$data['level']	= $level = getLevelDetails($db,$lvl);

// $dbyr = ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;	
$dbg  = VCPREFIX.$dbyr.DBG;
$dbg  = VCPREFIX.$dbyr.DBG;


$q = "
	SELECT distinct(sub.id) AS subject_id,sub.name AS subject
		FROM {$dbg}.05_courses AS crs
	INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
	INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
	WHERE 
			cr.level_id = '$lvl'
		AND sub.crstype_id = '1'	
	ORDER BY crs.position
	LIMIT 500;
";

$sth = $this->model->db->querysoc($q);
$data['subjects'] 		= $subjects		= $sth->fetchAll();
$data['num_subjects'] 	= $num_subjects	= count($data['subjects']);


$lbis = array();
for($i=0;$i<$num_subjects;$i++){
	$q = "
		SELECT 
			a.section,a.student,sub.name AS subject,g.`$fqtr` AS grade
		FROM {$dbg}.50_grades AS g 
		INNER JOIN (
			SELECT cr.name AS classroom,sxn.name AS section,sum.scid,c.name AS student,c.code AS student_code
			FROM {$dbg}.05_summaries AS sum
				INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
				INNER JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
				INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
			WHERE 
					cr.level_id = '$lvl'
				AND c.is_active = '1'
				AND sxn.code <> 'TMP'
		) AS a ON g.scid = a.scid
		
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		
		WHERE 	sub.id = '".$subjects[$i]['subject_id']."'
		ORDER BY grade DESC LIMIT 1	
	;";

	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$lbis[] = $row;

}

$data['lbis']	= $lbis;

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




public function students($params=NULL){	
$dbo=PDBO;

include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/classrooms.php");
require_once(SITE."functions/registration.php");
$db	=&	$this->model->db;
$today = $_SESSION['today'];

if(isset($_POST['add'])){
	// pr($_POST);
	$year 		   = $_SESSION['year'];
	$pass		   = MD5('pass');	
	$title_id	   = "1";
	$role_id 	   = "1";
	$privilege_id  = "1";
	$rows 		   = $_POST['contacts'];
	
	$pcid = lastContactId($db,$dbg);
		
	$q = "";
foreach($rows AS $row){
	
if(strlen($row['fullname'])>2){
	$fullname    = trim($row['fullname']);		
	$name_array = explode(' ',$fullname);

	$last_name   = isset($name_array[0])? trim(array_shift($name_array),',') : '';
	$first_name   = isset($name_array[0])? $name_array[0] : '';
	$middle_name   = isset($name_array[1])? $name_array[1] : '';	
	
	$code=$row['code'];
	$sy=$row['sy'];
	$code = preg_replace("([^0-9a-zA-Z-/])", "", $code);	
	$exists = validateCode($db,$code,$dbg);
	if(!$exists){		
		$pcid++;
	
		/* 1-contacts_tbl */
		$q .= " INSERT IGNORE INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`code`,
	`account`,`pass`,`passb`,`is_active`,`title_id`,`role_id`,`privilege_id`,`sy`,`created`,`is_male`,`crid`) 
			VALUES ('$pcid','$pcid','".$row['fullname']."','".$code."','".$code."','$pass','$pass','1',
		'$title_id','$role_id','$privilege_id','$sy','$today','".$row['is_male']."','".$row['crid']."'); ";

			
		/* 2-profiles_tbl */
		$q .= "
			INSERT IGNORE INTO {$dbo}.`00_profiles` (`contact_id`,`first_name`,`middle_name`,`last_name`) 
			VALUES ('$pcid','".$first_name."','".$middle_name."','".$last_name."');
		";
			
		/* 3-students_tbl */
		$q .= "
			INSERT IGNORE INTO {$dbg}.05_students (`contact_id`,`level_entry`,`year_entry`,`is_old`) VALUES
			('$pcid','".$row['level_id']."','$sy','0');";
						
		$q .= "
			INSERT IGNORE INTO {$dbg}.05_summaries (`scid`,`crid`,`acid`) 
			VALUES ('$pcid','".$row['crid']."','".$row['acid']."' ); ";
		$q .= " INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES ('$pcid'); ";
		$q .= " INSERT IGNORE INTO ".DBP.".photos(`contact_id`) VALUES ('$pcid'); ";
		$q .= " INSERT IGNORE INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`,`ctpb`) VALUES ('$pcid','pass','pass'); ";
		$q .= " INSERT IGNORE INTO {$dbg}.03_tsummaries (`scid`,`crid`) VALUES ('$pcid','".$row['crid']."'); ";
								
	} /* exists */

}	/* strlen over 2 meaning not empty */
		
			
}	/* foreach */
	// pr($q); exit;		
	$this->model->db->query($q);
	$url="setup/students";
	flashRedirect($url,'Students added.');
	
}	/* post-add */

	// pr($all);
	$all = (isset($_GET['all']))? true:false;
	
	$data['classrooms'] 	= ($all)? $this->model->fetchRows($dbg.'.05_classrooms','id,name','level_id,section_id'):tmpClassrooms($db,$dbg);
	// pr($data['classrooms']);exit;
	$data['lastnum'] 		= lastContactNumber($db,$sy);
	$data['laststud'] 		= lastContact($db,$sy,$stud=1);
	$data['prefix']			= $_SESSION['settings']['code_prefix'];
	$data['delimeter']		= $_SESSION['settings']['code_delimeter'];
	
	$this->view->render($data,'setup/students');

}	/* fxn */




/* creports,sync with GSController/reportCard */
public function gradebook($params){	
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/ratings.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/photos.php");
	$db =& $this->model->db;

	$data['ssy']	= $ssy		= $_SESSION['sy'];

	$data['crid']	= $crid   	= $params[0];
	$data['sy']		= $sy    	= isset($params[1])? $params[1] : $ssy;
	$qtr    		= isset($params[2])? $params[2] : $_SESSION['qtr'];

	$current		= ($sy==$ssy)? true:false; 	
	$qtr			= ($current)? $qtr:4;	
	$data['qtr']	= $qtr;
	$data['dbg']	= $dbg	= VCPREFIX.$sy.US.DBG;
	
	$data['user']	= $user		= $_SESSION['user'];
	$title_id 	= $user['title_id'];	
	$role_id 	= $user['role_id'];	
	if(!(($role_id == RREG) || ($role_id == RMIS))) { $this->flashRedirect('index/unauth'); } 
		
	/* controller - teachers or else */
	$data['home'] =	$home = $_SESSION['home']; 			

/* -------------------------------------------------------------------------------------------- */		

	$_SESSION['gradebook']['crid'] 		= $crid; 			
	if(isset($_POST['filter'])){
		/* $sy		= isset($_POST['cf']['sy'])? $_POST['sy'] : $sy; */
		$crid  		= $_POST['cf']['crid'];
		$sy			= $_POST['cf']['sy'];
		$_SESSION['gradebook']['crid'] 	= $crid; 
		$_SESSION['gradebook']['sy']  	= $sy;
		$url = 'gradebook/classroom/'.$crid.DS.$sy.DS.$qtr;		
		
		redirect($url);
	}	/* post-submit */
	
	
/* ----------------- process --------------------------------------------------------------------------- */		


$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order="c.`is_male` DESC,c.`name`",NULL,NULL,NULL,false);	

if($_SESSION['settings']['show_photos']==1){
$data['photos'] = getClassPhotos($db,$dbg,$sy,$crid,$male=2,$order="c.`is_male` DESC,c.`name`",NULL,NULL,NULL,false);	
}

	$data['num_students']	= $num_students = count($students);
	
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
	
	
	/* 1) grades,2) attendance,3) conducts,4) if applicable-psmapehs */
	
	for($i=0;$i<$num_students;$i++){		
		$students[$i]['summary'] 		= getStudentSummary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		/* @ library-GSModel */
		$students[$i]['grades'] 		= getStudentGrades($db,$dbg,$sy,$crid,$students[$i]['scid']); 		/* @ library-GSModel */
		$students[$i]['attendance'] 	= getStudentAttendance($db,$dbg,$sy,$students[$i]['scid']); 		
	}	/* for */ 

/* pr($classroom); */
if($classroom['conduct_ctype_id']==CTYPETRAIT){	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = getStudentTraits($db,$dbg,$sy,$students[$i]['scid']); }		
} else {	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = getStudentConducts($db,$dbg,$sy,$students[$i]['scid']); }				
}

if($_SESSION['settings']['psmapeh'] && $classroom['is_ps']){ 
	for($i=0;$i<$num_students;$i++){ $students[$i]['psmapehs'] = getStudentPsmapehs($db,$dbg,$sy,$students[$i]['scid']); } }	
	$data['students'] = $students;
	

/* ----------------- process --------------------------------------------------------------------------- */		
	
			
	$data['month_codes'] 	= getCodes($db,"{$dbo}.`05_months_quarters`");	
	$data['months'] 	 	= getAttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] 	= $this->model->getQuarterMonths($dbg);	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");

	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	/* arm-Model */
	$data['courses_locked'] = $courses_locked;
	// echo "crs locked: "; pr($courses_locked); exit;

	$data['printable']	= true;
	if($ssy == $sy){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;
	
		
	$this->view->render($data,'students/gradebook');		

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
  


public function studentSummarizer1($params){		/* from after edit student grades/ */
$dbo=PDBO;

	$fr = array('students','classifications','reports','equivs','details');
	$db =& $this->model->db;
	reqr($fr);

	$data['crid']	= $crid	= $params[0];	
	$data['scid']	= $scid	= $params[1];	
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['sy']		= $sy	= isset($params[2])? $params[2] : $ssy;
	$data['qtr']	= $qtr	= isset($params[3])? $params[3] : $sqtr;
	$dbg  = VCPREFIX.$sy.US.DBG;

	$data['classroom']  = $classroom	= getClassroomDetails($db,$crid,$dbg);				
	$data['cr']			= $classroom;	
	$data['is_locked'] 	= $classroom['is_finalized_q'.$qtr];
	$data['is_k12'] 	= $is_k12		= $classroom['is_k12'];
	$data['sem']		= $sem	= isset($params[4])? $params[4] : $classroom['is_sem'];
	$data['intfqtr']	= $intfqtr			= ($sem==2)? 6:5;
	$data['fqtr']		= $fqtr				= 'q'.$intfqtr;
	$data['iqtr']		= $iqtr	= ($qtr>4)? 4:$qtr;
	$data['derivsem']	= ($qtr<3)? 1:2;
	
	/* controller - teachers or else */
	$data['home']	= $home = $_SESSION['home']; 			

	$allowed = array(RMIS,RREG); /* 5-mis,9-registrars */	
	$srid = $_SESSION['user']['role_id']; 
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); } 
			
	$data['user']			= $_SESSION['user'];
	 
/* ------------------------------------------------------------------------------------------------- */		
/* dont move this,classyear for registrars; while classlistSummaries for teacher */
$order = " sum.ave_q$qtr DESC "; 	
/* ------------------------------------------------------------------------------------------------- */	
	
	$fields = " ,sum.ave_q1,sum.ave_q2,sum.ave_q3,sum.ave_q4,sum.ave_q5 
		,sum.ave_dg1,sum.ave_dg2,sum.ave_dg3,sum.ave_dg4,sum.ave_dg5 ";
	
	$data['student'] 	= student($db,$dbg,$sy,$scid);					
	
	
	/* post */
	if(isset($_POST['submit'])){
		$rows = $_POST['sum'];
		// pr($rows);
					
		/* 1 - update summaries */
		$q = "";
		foreach($rows AS $row){
			$expr = " `ave_q$intfqtr` = '".$row['ave']."' ";
			if($is_k12){ $expr .= " ,`ave_dg$intfqtr` = '".$row['ave_dg']."' "; }
			for($i=1;$i<=$iqtr;$i++){
				$expr .= " ,`ave_q$i` = '".$row['ave_q'.$i]."' ";		
				if($is_k12) { $expr .= " ,`ave_dg$i` = '".$row['ave_dg'.$i]."' ";	}				
			} 
			$q .= " UPDATE {$dbg}.05_summaries SET ";
			$q .= $expr;	
			$q .= " WHERE  `id` = '".$row['sumid']."' LIMIT 1; ";
		}	/* endforeach */		
		
		// pr($q);	exit;		
		$this->model->db->query($q);
				
		/* 3 - redirect to ccr */
		$url = "reports/ccr/$crid/$sy/$qtr";
		redirect($url);	
	}	/* post-submit */
	
	$data['num_students'] 	= 1;		
	$cfilter  = " AND (crs.in_genave = '1') "; 
	$cfilter .= ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;	
	
	$data['subjects'] 		= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter);	
	$data['num_subjects'] 	= count($data['subjects']);
	
	$units_array			= buildArray($data['subjects'],'units');
	$data['total_units'] 	= array_sum($units_array);
		
	$data['grades'][] = summarizer($db,$dbg,$sy,$scid,$crid,$acad=1,$agg=2,$cfilter,$limits=NULL,$electives=NULL);
		
	$crClass		 	= classifyClass($classroom);
	$data['ratings'] 	= getRatings($db,1,$crClass['dept_id']);		
		
	$this->view->render($data,'summarizers/student');		

}	/* summarizer */




/* for bonuses individual syncGrades like mis/syncGrades */ 
public function editStudentGrades($params){		
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
	$data['scid'] = $scid = $params[0];	
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$data['qtr'] = $qtr = isset($params[2])? $params[2]:$sqtr;
	
	$data['current']	= $current = ($sy==$ssy)? true:false;
	$dbyr 	= $sy.US;	
	$dbg  = VCPREFIX.$dbyr.DBG;
	$dbg  = VCPREFIX.$dbyr.DBG;

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
			
	$this->view->render($data,'registrars/editStudentGrades');

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



public function	photo($params=NULL){
$dbo=PDBO;
	$data['ucid']	= $ucid   = isset($params[0])? $params[0]:$_SESSION['user']['pcid'];
	$uc		= $this->model->fetchRow(PDBO.'.`00_contacts`',$ucid);
	$pcid	= $uc['parent_id'];

	if($ucid!=$pcid){ $ucid = $pcid; }

	$data['ssy'] 	= $ssy	= $_SESSION['sy'];
	$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

	$data['home']	= $home			= $_SESSION['home'];
	$_SESSION['url']	= "photos/one/$ucid";	

	// $dbyr	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;	
	$dbg = VCPREFIX.$dbyr.DBG; 
	$dbg = VCPREFIX.$dbyr.DBG; 
	$dbo=PDBO; 

	$q = " SELECT 
			c.*,p.*,c.id AS ucid,p.contact_id AS photoucid
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN ".DBP.".photos AS p ON p.contact_id = c.id
		WHERE c.id = '$ucid' LIMIT 1;		
	";
	

	$sth = $this->model->db->querysoc($q);
	$contact = $data['contact'] = $sth->fetch();
	// pr($contact);

	/* ----------------------- upload ------------------------------------------------------------------------------------ */
	if(isset($_POST['submit'])) {
		$tmp_file = $_FILES['file_upload']['tmp_name'];		
		$upload_dir = (LOCAL==1)? SITE.'public/photos/' : '/tmp/';				
		$name 		= $_FILES["file_upload"]["name"];
		$filename	= 'tmp.jpg';
		$target_file = (isNullOrEmpty($filename))?  $tmp_file : $filename;				
		$upfile = $upload_dir.$target_file;		
		// pr($upfile); exit;
		if(move_uploaded_file($tmp_file,$upfile)) {
					
			/* 1 - resize $tmp_file */	
			$imageClass = SITE.'library/Image.php';			
			include($imageClass);
			
			$image 		= new Img();		
			$photo_url 	= (LOCAL==1)? SITE.'public/photos/' : '/tmp/';
			$photo 		=  $photo_url.$filename;
					
			$image->load($photo);
			$image->resize(IMGW,IMGH);
			$image->save($photo);
			$file_size = filesize($photo);

			$fp 		= fopen($photo,'rb'); 
			$content 	= fread($fp,$file_size) or die("Error: cannot read file");
			fclose($fp);		

			$today = $_SESSION['today'];
			if(empty($contact['photoucid'])){
				$q = " INSERT INTO ".DBP.".photos (`contact_id`) VALUES ('$pcid');";			
				$this->model->db->query($q);
			} 
			$q = " UPDATE ".DBP.".photos SET `photo` = :content,`modified_date` = :today WHERE `contact_id` = :id LIMIT 1 ";			
			$sth = $this->model->db->prepare($q);
			// pr($q); pr($content); exit;
			$sth->execute(array(':content' => $content,':today' => $today,':id' => $pcid));						
			

			Session::set('message','File uploaded successfully.');		
		} else {
			$error = $_FILES['file_upload']['error'];
			Session::set('message','Upload failed.');
		}		
		$url = isset($_SESSION['url'])? $_SESSION['url']:'contacts/ucis/'.$ucid;	
		redirect($url);
			
	}	/* post */

	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$this->view->render($data,'photos/one');

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
$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order="c.is_male DESC,c.name",$fields="c.attschema_id,",$filter,$limits,$active);	



	$data['num_students']	= count($data['students']);		
	$this->view->render($data,'registrars/classlistManager');	



}	/* fxn */






	
public function sxns($params=NULL){
$dbo=PDBO;
$data['page']	= $page	= isset($params[0])? $params[0]:1;
$data['limit']	= $limit	= isset($params[1])? $params[1]:10;
$data['offset']	= $offset = ($page-1)*$limit;
$data['cond']	= $cond 	= isset($_GET['condition'])? $_GET['condition']:"sxn.code='TMP'";


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
pr($q);exit;
$data['q'] = $q;
$sth = $this->model->db->querysoc($q);
$data['students'] = $sth->fetchAll();
$data['count'] = count($data['students']);

$this->view->render($data,'registrars/sxns');


}	/* fxn */


  

public function gls($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/enrollment.php");
	require_once(SITE."functions/logs.php");	
	$db =& $this->model->db;

	$data['level_id']	= $level_id 	= isset($params[0])? $params[0]:1;
	$data['ssy']		= $ssy			= $_SESSION['sy'];
	$data['sy']			= $sy	  		= isset($params[1])? $params[1] : $ssy;
	$data['current']	= $current		= ($sy==$ssy)?  true:false;
	$data['home']		= $_SESSION['home'];
	$_SESSION['url']	= "sectioning/level/$level_id";
	$limit				= 500;	
	
	$dbg = PDBG;
	$dbg = PDBG;
			
	if(isset($_POST['edit'])){ $_SESSION['readonly'] = false; }
	if(isset($_POST['done'])){ $_SESSION['readonly'] = true; }

	$order = isset($_GET['grp'])? "c.grp,c.is_male DESC,c.name":NULL;		
	$fields = null;
	$filter = isset($_GET['all'])? NULL:"AND c.`sy`=$sy";	
	
	$data['students'] = $students = sectioningLevel($db,$dbg,$level_id,$limit,$order,$fields,$filter);
	$data['num_students'] 	= count($data['students']);

/* sync sum and tsum */		
	$q = "INSERT IGNORE INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`)VALUES";
	foreach($students AS $row){
		if(empty($row['sumscid'])){			
			$q.= "('".$row['scid']."','".$row['crid']."','".$row['acid']."'),";
		}						
	}	
	$q = rtrim($q,",");
	$q.=";";
	$db->query($q);
	
	$q = "INSERT IGNORE INTO {$dbg}.03_tsummaries(`scid`,`crid`)VALUES";
	foreach($students AS $row){
		if(empty($row['tsumscid'])){			
			$q.= "('".$row['scid']."','".$row['crid']."'),";
		}						
	}	
	$q = rtrim($q,",");
	$q.=";";
	$this->model->db->query($q);
/* sync sum and tsum */		
	
	
	if(isset($_POST['submit'])){
		$rows 	= $_POST['students'];
		// pr($_POST);
		$q = "";
		$i=0;
		foreach($rows AS $row){
			$scid = $row['scid'];
			$crid = $row['crid'];
			$acid = $row['acid'];
			$q .= " UPDATE {$dbo}.`00_contacts` SET 
				`grp` = '".$row['grp']."',  
				`is_active` = '".$row['is_active']."',  
				`is_cleared` = '".$row['is_cleared']."',  
				`is_male` 	= '".$row['is_male']."',  
				`sy` 	= '".$row['sy']."',  
				`prevcrid` 	= '".$row['prevcrid']."',  
				`crid` 	= '$crid'  
				WHERE `id` = '$scid' LIMIT 1; ";
				
				
		/* 2 - summaries */		
	$q .= " UPDATE {$dbg}.05_summaries SET `crid` 	= '".$row['crid']."',`acid` = '$acid'
			WHERE `scid` = '$scid' LIMIT 1;";
	$q .= " UPDATE {$dbg}.03_tsummaries SET `crid` 	= '".$row['crid']."' WHERE `scid` = '$scid' LIMIT 1;";
	
		
		/* echo (isset($student['sumscid']))? 'sumscid set':'sumscid NOT set'; */
		/* 3 - init students,profiles,photos,ctp if not exists */
		if(!isset($students[$i]['attdscid'])){ $q .= " INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES ('$scid');  "; }	
		if(!isset($students[$i]['studscid'])){ $q .= " INSERT IGNORE INTO {$dbg}.05_students (`contact_id`) VALUES ('$scid');  "; }	
		if(!isset($students[$i]['ctpscid'])){ $q .= " INSERT IGNORE INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$scid');  "; }	
		if(!isset($students[$i]['profscid'])){ $q .= " INSERT IGNORE INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$scid');  "; }	
		if(!isset($students[$i]['photoscid'])){ $q .= " INSERT IGNORE INTO ".DBP.".photos(`contact_id`) VALUES ('$scid');  "; }	
			
			
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
		
		$_SESSION['message'] = "Changes saved!";
		$url = "sectioning/level/$level_id";
		flashRedirect($url,'Sectioned students.');
		exit;
		
	}	/* post update submit */

	$_SESSION['photo_url'] = "sectioning/level/".$level_id;
		
	$fields = "*";
	if(isset($_GET['sxns'])){
		$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id,section_id");		
	} else {
		$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","section_id","WHERE level_id='$level_id' ");			
	}
	$data['level']	= getLevelDetails($db,$level_id,$dbg);
	$data['levels']			= $this->model->fetchRows("{$dbo}.`05_levels`","id,code,name","id");	
		
	$key = 'sectioningLevel';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];
	$data['has_axis'] = $_SESSION['settings']['has_axis'];
	
	$this->view->render($data,'sectioning/cridLevel');
	
}	/* fxn */

  

public function sectioning($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/enrollment.php");
	require_once(SITE."functions/logs.php");
	$db =& $this->model->db;

	$data['crid']	= $crid = $params[0];	
	$prevcrid = $crid;	/* for prevcrid */
	$data['ssy']	= $ssy 	= $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];
	
	$_SESSION['url']	= "sectioning/crid/$crid";		
	$data['current'] = $current = ($sy==$ssy)? true : false;
	
	$dbg = PDBG;
	$dbg = PDBG;

	$order = "c.is_male DESC,c.name";
	$fields=null;
	$filter = isset($_GET['all'])? NULL:"AND c.`sy`=$sy";
	$data['students'] = $students = sectioningClass($db,$dbg,$crid,$male=2,$order,$fields,$filter);	
	$data['num_students']	= count($data['students']);

/* sync sum and tsum */		
	$q = "INSERT IGNORE INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`)VALUES";
	foreach($students AS $row){
		if(empty($row['sumscid'])){			
			$q.= "('".$row['scid']."','".$row['crid']."','".$row['acid']."'),";
		}						
	}	
	$q = rtrim($q,",");
	$q.=";";
	$this->model->db->query($q);
	
	$q = "INSERT IGNORE INTO {$dbg}.03_tsummaries(`scid`,`crid`)VALUES";
	foreach($students AS $row){
		if(empty($row['tsumscid'])){			
			$q.= "('".$row['scid']."','".$row['crid']."'),";
		}						
	}	
	$q = rtrim($q,",");
	$q.=";";
	$this->model->db->query($q);
/* sync sum and tsum */		
	
	
if(isset($_POST['submit'])){
$studposts = $_POST['students'];
$q = "";
$i=0;
foreach($studposts AS $row){
	$scid = $row['scid'];
	$crid = $row['crid'];
	$acid = $row['acid'];
	/* 1 - contacts */		
	$q .= " UPDATE {$dbo}.`00_contacts` SET 
		`grp` = '".$row['grp']."',  
		`is_active` = '".$row['is_active']."',  
		`is_cleared` = '".$row['is_cleared']."',  
		`is_male` 	= '".$row['is_male']."',  
		`sy` 	= '".$row['sy']."',  
		`prevcrid` 	= '".$row['prevcrid']."',  
		`crid` 	= '$crid'  
		WHERE `id` = '$scid' LIMIT 1; ";
		
/* 2 - summaries */		
	$q .= " UPDATE {$dbg}.05_summaries SET `crid` 	= '".$row['crid']."',`acid` = '".$row['acid']."'
			WHERE `scid` = '$scid' LIMIT 1;";
	
	$q .= " UPDATE {$dbg}.03_tsummaries SET `crid` 	= '".$row['crid']."' WHERE `scid` = '$scid' LIMIT 1;";
				
	/* echo (isset($student['sumscid']))? 'sumscid set':'sumscid NOT set'; */
	/* 3 - init students,profiles,photos,ctp if not exists */
	if(!isset($students[$i]['attdscid'])){ $q .= " INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES ('$scid');  "; }	
	if(!isset($students[$i]['studscid'])){ $q .= " INSERT IGNORE INTO {$dbg}.05_students (`contact_id`) VALUES ('$scid');  "; }	
	if(!isset($students[$i]['ctpscid'])){ $q .= " INSERT IGNORE INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$scid');  "; }	
	if(!isset($students[$i]['profscid'])){ $q .= " INSERT IGNORE INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$scid');  "; }	
	if(!isset($students[$i]['photoscid'])){ $q .= " INSERT IGNORE INTO ".DBP.".photos(`contact_id`) VALUES ('$scid');  "; }	
	
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

$url = "sectioning/crid/$crid";
$this->flashRedirect($url,'Updated sectioning.');

exit;

}	/* post */

	
	$data['classroom']		= getClassroomDetails($db,$crid,$dbg);	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	

	$key = 'sectioning';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];
	
	$this->view->render($data,'sectioning/crid');	

}	/* fxn */






public function attendanceEmployeesIndex($params=NULL){
$dbo=PDBO;
$data['home'] = $home = $_SESSION['home'];
$data['sy']	  = $_SESSION['sy'];


require_once(SITE."functions/employees.php");
$db =& $this->model->db;

$dbg = PDBG;$dbg = PDBG;

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

$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;

$q = "
	SELECT 
		c.parent_id pcid,b.*,c.name AS contact
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN (
			SELECT att.* FROM {$dbg}.06_attendance_employees_logs AS att WHERE att.date = '$date'
		) AS b ON b.contact_id = c.id
	WHERE 
			c.role_id <> '".RSTUD."'	
		AND c.is_active = '1'	
		AND c.parent_id <> '1'	
		AND c.id = c.parent_id	
	ORDER BY c.name
;";
// pr($q);

$sth = $this->model->db->querysoc($q);
$data['attd'] = $sth->fetchAll();
$data['count'] = count($data['attd']);

$this->view->render($data,'registrars/attdem');

}	/* fxn */



public function editClassroomAdviser($params){
$dbo=PDBO;

require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid'] = $crid = $params[0];
$dbg = PDBG;

$data['classroom']	= getClassroomDetails($db,$crid,$dbg);	

$where = "WHERE role_id 	= ".RTEAC." AND is_active = 1 ";
$data['teachers']	= $this->model->fetchRows(PDBO.'.`00_contacts`','id,name',$order='name',$where);

$where = "WHERE role_id 	= ".RACAD." AND is_active = 1 ";
$data['coordinators']	= $this->model->fetchRows(PDBO.'.`00_contacts`','id,name',$order='name',$where);

if(isset($_POST['submit'])){
	$row = $_POST;
	$q = "UPDATE $dbg.05_classrooms SET 
		`acid` = ".$row['acid'].",
		`hcid` = ".$row['hcid']."
		WHERE `id` = '$crid' LIMIT 1;
	";
	$db->query($q);
	$url = $_SESSION['url'];
	redirect($url);
	exit;
}	/* post */


$this->view->render($data,'registrars/editClassroomAdviser');

}	/* fxn */


public function openCQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;

	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '0',`finalized_date_q{$qtr}` = '0000-00-00';";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	flashRedirect($url,"Qtr $qtr courses opened.");

}	/* fxn */


public function closeCQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$today = $_SESSION['today'];
	$qtr = $params[0];
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '1',`finalized_date_q{$qtr}` = '$today';";
	$this->model->db->query($q);

	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	flashRedirect($url,"Qtr $qtr courses closed.");

}	/* fxn */


public function openAttd($params=null){		/* set all attd-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = 0; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Students Attendance for Qtr $qtr opened!";
	redirect($url);
}	/* fxn */


public function closeAttd($params=null){		/* set all attd-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = 1; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Students Attendance for Qtr $qtr closed!";
	redirect($url);
}	/* fxn */


public function openAQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;

	include_once(SITE.'views/elements/params_qs.php');
	$today  = $_SESSION['today'];
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = 0,`finalized_date_q$qtr` = '$today'; ";
	$this->model->db->query($q);

	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Advisory classes for Qtr $qtr opened!";
	redirect($url);


}	/* fxn */


public function closeAQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;

include_once(SITE.'views/elements/params_qs.php');
$today  = $_SESSION['today'];

$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = 1,`finalized_date_q$qtr` = '$today'; ";
$this->model->db->query($q);

$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
$_SESSION['message'] = "Advisory classes for Qtr $qtr locked!";
redirect($url);

}	/* fxn */


public function unsetter($params=NULL){
$dbo=PDBO;
	$key = $params[0];
	$_SESSION[$key] = NULL;	
	unset($_SESSION[$key]);
	echo "Unset $key";

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
$ssy = $_SESSION['sy'];
$sy = isset($params[1])? $params[1]:$ssy;
$dbyr = $sy.US;
$dbg = VCPREFIX.$dbyr.DBG;
$dbg = VCPREFIX.$dbyr.DBG;
$q = "
	SELECT
		c.id AS ucid,c.parent_id AS pcid,c.account,c.pass,		
		ctp.ctp,c.name AS adviser,cr.name AS classroom,cr.id AS crid,
		ctp.contact_id AS ctpucid,p.contact_id AS profpcid,ph.contact_id AS photopcid,pc.name AS pcname
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN ".DBP.".photos AS ph ON ph.contact_id = c.parent_id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.parent_id
	WHERE cr.id = '$crid' LIMIT 1;	
";
$sth = $this->model->db->querysoc($q);
$data['row'] = $row = $sth->fetch();

$sync=false;
$q = ""; 
if(empty($row['adviser'])) { $q .= "UPDATE {$dbo}.`00_contacts` SET `name` = '".$row['pcname']."' WHERE `id` = '".$row['ucid']."';"; $sync=true; }
if(empty($row['ctpucid'])) { $q .= "INSERT INTO {$dbo}.`00_ctp`(`contact_id`) VALUES ('".$row['ucid']."');"; $sync=true; }
if(empty($row['profpcid'])) { $q .= "INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('".$row['pcid']."');"; $sync=true; }
if(empty($row['photopcid'])) { $q .= "INSERT INTO ".PDBP.".photos(`contact_id`) VALUES ('".$row['pcid']."');"; $sync=true; }
$url = "registrars/classroom/$crid";
// pr($q);exit;
if($sync){ 
	$this->model->db->query($q);
	flashRedirect($url,'Adviser info synced.'); 
}


$this->view->render($data,'registrars/classroom');

}	/* fxn */



public function editStudentAttendance($params){
$dbo=PDBO;
	require_once(SITE."functions/grades.php");
	$db =& $this->model->db;

	
$ssy = $_SESSION['sy'];
$data['scid'] = $scid = $params[0];
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;

$dbyr = $sy.US;
$dbg = VCPREFIX.$dbyr.DBG;
$dbg = VCPREFIX.$dbyr.DBG;

$data['attendance'] = getStudentAttendance($db,$dbg,$sy,$scid);

	if(!isset($_SESSION['months'])){ $_SESSION['months'] = $this->model->fetchRows(DBO.'.months','*','id'); } 
	$data['months'] = $months = $_SESSION['months'];	

if(isset($_POST['submit'])){
	// pr($_POST);
	
	$q = "UPDATE {$dbg}.05_attendance SET ";
	foreach($months AS $month){
		$mocode=$month['code'];
		$q .= "`{$mocode}_days_present` = '".$_POST[$mocode]['present']."',";
		$q .= "`{$mocode}_days_tardy` = '".$_POST[$mocode]['tardy']."',";
	}
	$q = rtrim($q,',');
	$q .= " WHERE `scid` = '$scid' LIMIT 1; ";
	// pr($q); exit;
	$db->query($q);
	$url = "attendance/edit/$scid/$sy";
	// pr($url);
	flashRedirect($url,'Student attendance edited.');
	exit;
	
}	/* post */

$this->view->render($data,'attendance/edit');

}	/* fxn */




public function filter($params=NULL){ 
$dbo=PDBO;
	$data['home']	= $_SESSION['home'];	
		
if(isset($_GET['filter'])){
	// pr($_POST);
	$post = $_GET;
	$cond = NULL;
	$cond .= "";	
	if (!empty($post['lvlid'])){ $cond .= " AND cr.level_id = '".$post['lvlid']."'"; }				
	if (!empty($post['crid'])){ $cond .= " AND cr.id = '".$post['crid']."'"; }				
	if (!empty($post['sy'])){ $cond .= " AND c.`sy` = '".$post['sy']."'"; }				
		
	$sort   = (isset($post['sort']))?$post['sort']:'c.name';
	$order  = (isset($post['order']))?$post['order']:'ASC';
	
	// $dbyr = $post['sy'].US;
	// $dbg = VCPREFIX.$dbyr.DBG;
	// $dbg = VCPREFIX.$dbyr.DBG;
	$dbg = PDBG;
	$dbg = PDBG;
	
	$q = "
		SELECT 			
			ctp.ctp,
			c.id AS ucid,c.parent_id AS pcid,
			sum.crid AS sumcrid,sum.scid AS sumscid,sum.acid AS sumacid,		
			cr.name AS classroom,
			c.*,c.id AS scid,c.name AS student,c.`sy`,
			cr.acid,
			cr.id AS crid,
			t.total,l.name AS level,sxn.name AS section,
			cr.level_id,c.code AS student_code,
			s.contact_id AS studscid,p.contact_id AS profscid,ph.contact_id AS photoscid,ctp.contact_id AS ctpscid,
			tsum.scid AS tsumscid,
			attd.scid AS attdscid			
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS sum on sum.scid = c.id
			LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on sum.crid = cr.id			
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t on cr.level_id = t.level_id
			LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
			LEFT JOIN ".DBP.".photos AS ph on ph.contact_id = c.id					
		WHERE c.role_id = '".RSTUD."' $cond ORDER BY $sort $order ;		
	";
	$data['q'] = $q;
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
		
			
} /* get */


	// $data['feetypes'] = $_SESSION['feetypes'];	
	// $data['contacts'] = $this->model->fetchRows(PDBO.".`00_contacts`",'id,parent_id,name');

	$data['classrooms'] = $_SESSION['classrooms'];	
	$data['levels'] = $_SESSION['levels'];	
	
	$this->view->render($data,'registrars/filter');
	

}	/* fxn */



public function roster($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$dbg=PDBG;
$dbg=PDBG;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['sy'] = $_SESSION['sy'];
$data['classroom'] = getClassroomDetails($db,$crid);
$lvlid = $data['classroom']['level_id'];

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
	// pr($q);
	
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	
} /* if */



$this->view->render($data,'rosters/classroom');


}	/* fxn */






public function rosterBatch($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$dbg=PDBG;
$dbg=PDBG;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['sy'] = $_SESSION['sy'];
$data['classroom'] = getClassroomDetails($db,$crid);
$lvlid = $data['classroom']['level_id'];
$data['acid'] = $acid = $data['classroom']['acid'];
$dbyr = DBYR;

if(isset($_POST['add'])){
	// pr($_POST);	
	$posts = $_POST['posts'];		
	$q = "";
	foreach($posts AS $code){
		$empty = (empty($code))? true:false;
		if(!$empty){
			$code = preg_replace("([^A-Za-z0-9-/])", "", $code);																
			$qry = "SELECT id AS scid,crid AS prevcrid FROM {$dbo}.`00_contacts` WHERE `code` = '$code' LIMIT 1;";
			$sth = $db->querysoc($qry);
			$row = $sth->fetch();
			
			if($row){
				$scid=$row['scid'];
				$q.= $this->sxnThis($db,$sy,$scid,$crid);
			}	
		}		
	}
	
	// pr($q);
	
	$db->query($q);
	$url = "rosters/batch/$crid";
	flashRedirect($url,'Batch roster processed.');
	
	
	exit;

}	/* post */


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



$this->view->render($data,'rosters/batch');


}	/* fxn */


private function sxnThis($db,$sy,$scid,$crid){
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q="UPDATE {$dbo}.`00_contacts` SET `is_active` =1,prevcrid=crid,`crid`=$crid WHERE `id`='$scid' LIMIT 1;";	
	$q.="UPDATE {$dbg}.05_summaries SET `crid`=$crid WHERE `scid`=$scid LIMIT 1;";		
	$q.="UPDATE {$dbo}.05_enrollments SET `crid`=$crid WHERE `sy`=$sy AND `scid`='$scid' LIMIT 1;";
	return $q;	

}	/* fxn */



public function rosterSync($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;$dbg=PDBG;
$data['crid'] = $crid = isset($params[0])? $params[0]:false;
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$data['sy']=$sy=$dbyr=DBYR;
$data['classroom'] = getClassroomDetails($db,$crid);
$lvlid = $data['classroom']['level_id'];
$data['acid'] = $acid = $data['classroom']['acid'];

$q = "SELECT id AS tmpcrid FROM {$dbg}.05_classrooms WHERE `level_id` = '$lvlid' AND `section_id` = '1' LIMIT 1;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$data['tmpcrid'] = $tmpcrid = $row['tmpcrid'];


$q="SELECT cr.id AS outcrid FROM {$dbg}.05_classrooms AS cr LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id
WHERE cr.`level_id` = '$lvlid' AND s.`code` = 'OUT' LIMIT 1;";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$data['outcrid'] = $row['outcrid'];
$data['tmpcrid'] = $tmpcrid = $row['outcrid'];


if($crid){
	$q="SELECT c.id AS scid,c.code,c.name AS student,c.position,c.is_active FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id WHERE summ.crid = '$crid' ORDER BY c.name;";	
	$sth = $db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
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
				$q.= $this->sxnThis($db,$sy,$scid,$crid); 
			}	
			
			
		}		
	}	/* foreach */
	// pr($q);
	
	// echo '<hr />';
	
	$tx = array_diff($ar,$br);
	$ix = array_diff($br,$ar);
	
	$q="";
	foreach($tx AS $scid){
		$row['scid'] = $scid;
		$q.= $this->sxnThis($db,$sy,$scid,$crid);	
	}	/* foreach */

	// pr($q); 
	// exit;
	$db->query($q);
	$url="rosters/sync/$crid";
		flashRedirect($url,'Roster Synced.');
		exit;
	
}	/* post */


$this->view->render($data,'rosters/sync');


}	/* fxn */



public function codename($params=NULL){
$data['ucid'] = $ucid=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$dbo=PDBO;
if($ucid){
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE `id`='$ucid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	// pr($_POST);
	$post=$_POST['post'];
	$code=$post['code'];
	$name=$post['name'];
	$is_male=$post['is_male'];
	$q="UPDATE {$dbo}.`00_contacts` SET `code`='$code',`account`='$code',`name`='$name',`is_male`='$is_male' 
		WHERE `id`='$ucid' LIMIT 1; ";
	$db->query($q);
	$url="codename/one/$ucid";
	redirect($url);
	// pr($q);
	exit;
	
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'codename/one');

}	/* fxn */




} 	/* RegistrarsController */
