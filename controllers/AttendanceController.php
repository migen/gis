<?php


class AttendanceController extends Controller{	
/* for all roles  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}



public function index(){
	// $this->model->index();
	$db=&$this->baseModel->db;$dbg=PDBG;$data="attendance";	
	$this->view->render($data,"attendance/indexAttendance");	
	
}	/* fxn */



public function student($params){
$dbo=PDBO;
require_once(SITE."functions/grades.php");
$db =& $this->model->db;
	
$ssy = $_SESSION['sy'];
$data['scid'] = $scid = $params[0];
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$data['qtr'] = $qtr = isset($params[2])? $params[2]:$_SESSION['qtr'];

$dbg = VCPREFIX.$sy.US.DBG;

$data['attendance'] = getStudentAttendance($db,$dbg,$sy,$scid);

$data['srid']=$srid=$_SESSION['srid'];
$data['is_admin']=$is_admin=(($srid==RMIS) || ($srid==RREG))? true:false;

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

	$q.="`q5_days_present`='".$_POST['total_days_present']."',`q5_days_tardy`='".$_POST['total_days_tardy']."',
	`total_days_present`='".$_POST['total_days_present']."',`total_days_tardy`='".$_POST['total_days_tardy']."' ";
	$q .= " WHERE `scid` = '$scid' LIMIT 1; ";
	// pr($q);exit;
	$db->query($q);
	$url = "attendance/student/$scid/$sy";
	flashRedirect($url,'Student attendance edited.');
	exit;
	
}	/* post */

$vfile='attendance/studentMonthlyAttendance';vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function studentQtr($params){
$dbo=PDBO;
require_once(SITE."functions/grades.php");
$db=&$this->model->db;
	
$ssy = $_SESSION['sy'];
$data['scid'] = $scid = $params[0];
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$data['qtr'] = $qtr = isset($params[2])? $params[2]:$_SESSION['qtr'];

$dbg = VCPREFIX.$sy.US.DBG;
$data['attendance'] = getStudentAttendance($db,$dbg,$sy,$scid);
$q="SELECT c.*,cr.level_id AS lvl,summ.crid AS crid FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
WHERE c.id='$scid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['student']=$sth->fetch();
$data['crid']=$crid=$data['student']['crid'];
$data['lvl']=$lvl=$data['student']['lvl'];


$q="SELECT * FROM {$dbg}.05_attendance_months WHERE level_id='$lvl' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['attmos']=$sth->fetch();

if(isset($_POST['submit'])){
	
	$q = "UPDATE {$dbg}.05_attendance SET 
		q1_days_present='".$_POST['q1_days_present']."',q2_days_present='".$_POST['q2_days_present']."', 
		q3_days_present='".$_POST['q3_days_present']."',q4_days_present='".$_POST['q4_days_present']."', 
		q1_days_tardy='".$_POST['q1_days_tardy']."',q2_days_tardy='".$_POST['q2_days_tardy']."', 
		q3_days_tardy='".$_POST['q3_days_tardy']."',q4_days_tardy='".$_POST['q4_days_tardy']."',
		q5_days_present='".$_POST['total_days_present']."',q5_days_tardy='".$_POST['total_days_tardy']."',		
		total_days_present='".$_POST['total_days_present']."',total_days_tardy='".$_POST['total_days_tardy']."'		
		WHERE `scid` = '$scid' LIMIT 1; ";
	$db->query($q);
	$url = "attendance/studentQtr/$scid/$sy";
	flashRedirect($url,'Student attendance edited.');
	exit;
	
}	/* post */


$vfile='attendance/studentQuarterlyAttendance';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */


public function monthly($params){	
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");

	$crid 		= $params[0];	
	$ssy		= $_SESSION['sy'];	
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$home 		= $data['home']	= $_SESSION['home'];
	$current	= $data['current']	= ($sy==DBYR)? true:false;	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
	if(!in_array($srid,$allowed)){ flashRedirect($home); }	
	$data['is_admin']=$is_admin=(in_array($srid,$allowed))? true:false;
	
	/* is_locked = advisers_quarters.attendance_q# */
	$cr = $data['classroom']  = getClassroomDetails($db,$crid,$dbg);	
	if($qtr < 5){ 	$data['is_locked'] = ($cr['attendance_q'.$qtr]==1)? true:false; } else { $data['is_locked']=false; }
	
	$months = $data['months_quarters'] = gisMonthsQuarters($db,$qtr);
 	 
	if(isset($_POST['subtotal'])){	/* subtotal - submit total */
		$rows = $_POST['total'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbg}.05_attendance SET `total_days_present` = '".$row['tdpre']."',`total_days_tardy` = '";	
			$q.= $row['tdtar']."'  WHERE `id` = '".$row['id']."' LIMIT 1;  ";
		}
		$q .= " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q4` = 1 WHERE `crid` = '$crid' LIMIT 1; ";
		$db->query($q);			
		$url = "attendance/monthly/$crid/$sy/4";
		flashRedirect($url,'SY Attendance closed.');
			
	}	/* subtotal */
	
	if(isset($_POST['submit'])){
		$rows = $_POST['data']['Attendance'];		
		$q  = "";		
		foreach($rows AS $row){
			$q .= " UPDATE {$dbg}.05_attendance SET ";			
			foreach($months AS $month){
				$mc = $month['code'];
				$q .= " `".$mc."_days_present` = '".$row[$mc.'_days_present']."',";
				$q .= " `".$mc."_days_tardy` = '".$row[$mc.'_days_tardy']."',";
			}
			$q = rtrim($q,",");			
			$q .= " WHERE `id` = '".$row['id']."' LIMIT 1; "; 			
		}		
		$db->query($q);		
		/* 2 */
		if($qtr==4){
			$q="UPDATE {$dbg}.05_attendance AS a INNER JOIN {$dbg}.05_summaries AS b ON a.scid=b.scid
				SET a.`total_days_present`=(jun_days_present+jul_days_present+aug_days_present+sep_days_present
					+oct_days_present+nov_days_present+dec_days_present+jan_days_present+feb_days_present+mar_days_present+apr_days_present),
					a.`total_days_tardy`=(jun_days_tardy+jul_days_tardy+aug_days_tardy+sep_days_tardy
					+oct_days_tardy+nov_days_tardy+dec_days_tardy+jan_days_tardy+feb_days_tardy+mar_days_tardy+apr_days_tardy)
				WHERE b.crid='$crid'; ";				
			$db->query($q);
		}
				
	}	/* post-submit */
	
/* ---------------------- process ---------------------------------------------------------------- */	
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.=$_SESSION['settings']['classlist_order'];	
	$fields="c.attschema_id,";
	$filter=null;
	$limits=null;
	$active=false;
	$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);	
	
	$data['num_students'] = count($data['students']);		
	$data['attendance_months'] 	= getAttendanceMonths($db,$cr['level_id'],$sy,$dbg);	 	
	foreach($data['students'] AS $row){ $data['attendance'][] = getStudentAttendance($db,$dbg,$sy,$row['scid']); }
	$data['today']		= $_SESSION['today'];
	$data['crid']		= $crid;
	
if($_SESSION['srid']==RTEAC){ 
	if($_SESSION['user']['privilege_id']>0 && !in_array($crid,$_SESSION['teacher']['advisory_ids'])){ flashRedirect('teachers'); } 
}
	$_SESSION['crid'] = "$crid";	
	$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms");
	// $vfile=isset($_GET['view'])? 'attendance/monthlyAttendanceView':'attendance/monthlyAttendance';vfile($vfile);
	$vfile='attendance/monthlyAttendance';vfile($vfile);
	$this->view->render($data,$vfile);

} 	/* fxn */



public function quarterly($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classlists.php");

	$data['crid'] = $crid 		= $params[0];	
	$ssy		= $_SESSION['sy'];	
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$home 		= $data['home']	= $_SESSION['home'];
	$current	= $data['current']	= ($sy==$ssy)? true:false;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
	// if($srid==RTEAC && $_SESSION['user']['privilege_id']>0){ flashRedirect($home); }
	
	if(!in_array($srid,$allowed)){ flashRedirect($home); }	
	$data['is_admin']=$is_admin=(in_array($srid,$allowed))? true:false;
	
	$data['cr'] = $cr = $data['classroom']  = getClassroomDetails($db,$crid,$dbg);		
	$acid=$cr['acid'];
	if(!canViewClasslist($db,$acid,$crid)){ flashRedirect($home); }

	if($qtr < 6){ 	$data['is_locked'] = ($cr['attendance_q'.$qtr]==1)? true:false; }
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.="c.is_male DESC,c.name";	
	$fields="c.attschema_id,";
	$filter=null;
	$limits=null;
	$active=false;

	$lvl=$cr['level_id'];
	$q="SELECT * FROM {$dbg}.05_attendance_months WHERE `level_id`='$lvl' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['attdmos']=$sth->fetch();
	// pr($qv);
	$data['qv']=$qv=($qtr<5)? "q{$qtr}":"total";
	$classlist_order=$_SESSION['settings']['classlist_order'];
	$sort=isset($_GET['sort'])? $_GET['sort']:$classlist_order;
	
	$q="
		SELECT 
			a.id AS attid,c.id AS scid,c.name AS student,c.code,c.position,
			a.{$qv}_days_present AS present,{$qv}_days_tardy AS tardy,
			a.q1_days_present,a.q1_days_tardy,a.q2_days_present,a.q2_days_tardy,
			a.q3_days_present,a.q3_days_tardy,a.q4_days_present,a.q4_days_tardy
		FROM {$dbg}.05_summaries AS summ  
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_attendance AS a ON summ.scid=a.scid
		WHERE summ.crid='$crid' ORDER BY $sort LIMIT 100;
	";
	// pr($q);
	if(isset($_GET['debug'])){ pr($q); }
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	
	
/* 2 sync if lacking attd */
$q="";
foreach($rows AS $row){
	if(empty($row['attid'])){ $q.="INSERT INTO {$dbg}.05_attendance(`scid`)VALUES('".$row['scid']."');"; }
}
$sth=$db->query($q);
if($sth){flashRedirect("attendance/quarterly/$crid",'Synced attd.');}

	if(isset($_POST['save'])){
		$q="";
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			if(($post['oldpre']!=$post['present']) || ($post['oldtar']!=$post['tardy'])){
				$q.="UPDATE {$dbg}.05_attendance SET 
					`{$qv}_days_present`='".$post['present']."',`{$qv}_days_tardy`='".$post['tardy']."' 
					WHERE `id`='".$post['attid']."' LIMIT 1;";			
			}	/* if !same */

		}		
		
		$db->query($q);
		if($qtr==5){
			$q="";
			foreach($posts AS $post){
				if(($post['oldpre']!=$post['present']) || ($post['oldtar']!=$post['tardy'])){			
					$q.="UPDATE {$dbg}.05_attendance SET `q5_days_present`='".$post['present']."',
					`q5_days_tardy`='".$post['tardy']."' WHERE `id`='".$post['attid']."' LIMIT 1;";
				}	/* !same */
			}		
		}	/* final */
		// pr($posts);
		// pr($q); exit;
		$db->query($q);	
		if($qtr==4){
			$q="UPDATE {$dbg}.05_attendance AS a INNER JOIN {$dbg}.05_summaries AS b ON a.scid=b.scid
				SET 
					a.`total_days_present`=(q1_days_present+q2_days_present+q3_days_present+q4_days_present),
					a.`total_days_tardy`=(q1_days_tardy+q2_days_tardy+q3_days_tardy+q4_days_tardy),
					a.`q5_days_present`=(q1_days_present+q2_days_present+q3_days_present+q4_days_present),
					a.`q5_days_tardy`=(q1_days_tardy+q2_days_tardy+q3_days_tardy+q4_days_tardy)							
				WHERE b.crid='$crid'; ";
			$db->query($q);
		}
	
		if($_POST['save']=='Finalize'){ flashRedirect("finalizers/closeAttendance/$crid/$sy/$qtr","Saved and Locked."); }
		
		$url="attendance/quarterly/$crid/$sy/$qtr";
		flashRedirect($url,'Attendance Quarter saved.');		
		exit;
	}	/* post */
	
	$data['count']=count($rows);
	$vfile=($qtr<5)? "attendance/quarterlyAttendance":"attendance/quarterly_totalAttendance";
	// $vfile=isset($_GET['view'])? 'attendance/quarterlyAttendance':'attendance/quarterlyAttendance';
	vfile($vfile);
	
	$this->view->render($data,$vfile);

}	/* fxn */




public function totalCridMonthly($params=NULL){
$data['crid']=$crid=isset($params[0])?$params[0]:false;
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$db=&$this->model->db;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
$q="
	UPDATE {$dbg}.05_attendance AS a 
		INNER JOIN {$dbg}.05_summaries AS b ON a.scid=b.scid
	SET a.total_days_present=(a.jun_days_present+a.jul_days_present+a.aug_days_present+a.sep_days_present
		+a.oct_days_present+a.nov_days_present+a.dec_days_present+a.jan_days_present+a.feb_days_present
		+a.mar_days_present+a.apr_days_present+a.may_days_present),a.total_days_tardy=(a.jun_days_tardy+a.jul_days_tardy
		+a.aug_days_tardy+a.sep_days_tardy+a.oct_days_tardy+a.nov_days_tardy+a.dec_days_tardy
		+a.jan_days_tardy+a.feb_days_tardy+a.mar_days_tardy+a.apr_days_tardy+a.may_days_tardy)
	WHERE b.crid='$crid';";
$sth=$db->query($q);
$msg=($sth)? "Total Processed.":"Total Failed.";
$url="attendance/monthly/$crid/$sy/5";
flashRedirect($url,$msg);

}	/* fxn */


public function annualQtr($params){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/grades.php");

	$data['crid'] = $crid 		= $params[0];	
	$ssy		= $_SESSION['sy'];	
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$home 		= $data['home']	= $_SESSION['home'];
	$current	= $data['current']	= ($sy==$ssy)? true:false;
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
	
	if(!in_array($srid,$allowed)){ flashRedirect($home); }	
	$data['is_admin']=$is_admin=(in_array($srid,$allowed))? true:false;
	
	$data['cr'] = $cr = getClassroomDetails($db,$crid,$dbg);		
	$acid=$cr['acid'];
	$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];
	
	$q="SELECT 
			a.id AS attid,c.id AS scid,c.name AS student,c.code,c.position,
			a.q1_days_present,a.q2_days_present,a.q3_days_present,a.q4_days_present,a.q5_days_present,
			a.q1_days_tardy,a.q2_days_tardy,a.q3_days_tardy,a.q4_days_tardy,a.q5_days_tardy
		FROM {$dbg}.05_summaries AS summ  
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_attendance AS a ON summ.scid=a.scid
		WHERE summ.crid='$crid' ORDER BY $order LIMIT 100; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$data['attmos']=getAttendanceMonths($db,$cr['level_id'],$sy,$dbg);	 	
		
	
	$this->view->render($data,'attendance/annualQtrAttendance');
	
}	/* fxn */




} 	/* AttendanceController */