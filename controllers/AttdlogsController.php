<?php

Class AttdlogsController extends Controller{	

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



public function person($params){
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	require_once(SITE."functions/employees.php");
	require_once(SITE."functions/times.php");
	$db =& $this->model->db;

	$data['home'] 	= $home 		= $_SESSION['home'];
	$data['sy']		= $sy			= $params[0];	
	$data['moid']	= $moid			= $params[1];	
	$ucid			= isset($params[2])? $params[2] : $_SESSION['user']['ucid'];
	$data['user']	= $user	= $_SESSION['user'];
	$data['suid'] 	= $suid			= $user['ucid'];
	$data['srid']	= $srid			= $user['role_id'];
	
	$data['mis']	= $mis 	= ($srid==RMIS)? true:false;
	$data['reg']	= $reg 	= ($srid==RREG)? true:false;
	$data['guid']	= $guid 	= ($srid==RGUID)? true:false;
	
	if($srid==RSTUD){ $ucid 	= $suid; } 	
	if($mis || $reg || $guid){
	} else { $ucid 	= $suid; }
	
	$data['ucid'] 	= $ucid;
	
	$data['mine']	= $mine	= ($ucid==$suid)? true:false;	

	$ssy	= $_SESSION['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data['contact'] = $contact = $this->model->contactAttendance($dbg,$sy,$ucid,$fields="");	
	$data['empl']	 = $empl	= ($contact['role_id']==RSTUD)? false:true;	
	$_SESSION['attendance_logs'] = "attdlogs/person/$sy/$moid/$ucid";
	$att = ($empl)? 'attendance_employees_logs':'attendance_logs';
	
	$year 	= getSY($sy,$moid);
	$mo	 	= getMonth($db,$moid,$code=true,$dbg);
	$mo 	= ucfirst($mo);

/* -------------------------------------------------------------------------- */	
		
	$data['urid'] 	= $urid 		= $contact['role_id'];	
	$data['crid'] 	= $crid 		= $contact['crid'];	
		
		
/* -------------------------------------------------------------------------- */	

if(isset($_POST['submit'])){
	$rows = $_POST['al'];
	$q = " INSERT INTO {$dbg}.`$att` (`contact_id`,`date`,`timein`,`timeout`,`minutes_tardy`,`minutes_undertime`) VALUES ";
	foreach($rows AS $row){ 
$q .= " ('$ucid','".$row['date']."','".$row['timein']."','".$row['timeout']."','".$row['minutes_tardy']."','".$row['minutes_undertime']."'),"; }
	$q = rtrim($q,",");	
	$q .= ";";
	// pr($q); 	 exit;
	$this->model->db->query($q);
	$url = "attdlogs/person/$sy/$moid/$ucid";
	redirect($url); 
	exit;	

}


/* -------------------------------------------------------------------------- */	
	$q = "
		SELECT
			cal.*,att.*,att.id AS attid
		FROM {$dbg}.`$att` AS att
			LEFT JOIN {$dbg}.05_calendar AS cal ON cal.date = att.date
		WHERE 	att.`contact_id` 	= '$ucid'
			AND  YEAR(att.`date`) 	= '$year'
			AND  MONTH(att.`date`) 	= '$moid'
		ORDER BY att.`date` DESC		
	"; 
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['attendances'] 		= $sth->fetchAll();
	$data['num_attendances']	= count($data['attendances']);
	$data['yrmonth']			= $year.' - '.$mo;
	
	$data['months']	= $this->model->fetchRows(DBO.".months",'*');
	if($_SESSION['settings']['attendance_employees']==1){
		if(empty($_SESSION['employees'])){
			$fields = NULL;
			$filters="AND c.is_active = 1";			
			$employees = employees($db,$dbg,$fields,$filters);
			$_SESSION['employees'] = $employees; 
			$_SESSION['count_employees'] = count($employees);
		}
		$data['count_employees']	= $_SESSION['count_employees'];					
	}
	
	$this->view->render($data,'attdlogs/person');
	

}	/* fxn */



public function deleteAttendanceLog($params){
	$dbo=PDBO;
	$ssy 	= $_SESSION['sy'];
	$sy		= $params[0];
	$attid	= $params[1];
	$empl	= $params[2];
	$att	= ($empl)? 'attendance_employees_logs':'attendance_logs';

	$dbg = ($sy==$ssy)? DBG:$sy.US.DBG;

	$q = " DELETE FROM {$dbg}.`$att` WHERE `id` = '$attid' LIMIT 1; ";
	$this->model->db->query($q);

	$url = isset($_SESSION['attendance_logs'])? $_SESSION['attendance_logs'] : 'index';
	redirect($url);

}	/* fxn */



public function attendanceHalf($params){
	$dbo=PDBO;
	require_once(SITE."functions/times.php");
	$db =& $this->model->db;

	$this->view->js = array('js/jquery.js','js/vegas.js');	
	$data['home'] 	= $home 		= $_SESSION['home'];
	$data['half']	= $half			= ($params[0]=='1st')? '1':'2';
	$compare		= ($half==1)? '<':'>=';	
	
	$data['sy']		= $sy			= $params[1];	
	$data['moid']	= $moid			= $params[2];	
	$data['user']	= $_SESSION['user'];
	$ucid			= isset($params[3])? $params[3] : $_SESSION['ucid'];

	$data['user']	= $user	= $_SESSION['user'];
	$data['suid'] 	= $suid			= $user['ucid'];
	$data['srid']	= $srid			= $user['role_id'];
	
	$data['mis']	= $mis 	= ($srid==RMIS)? true:false;
	$data['reg']	= $reg 	= ($srid==RREG)? true:false;
	$data['guid']	= $guid 	= ($srid==RGUID)? true:false;
	
	if($srid==RSTUD){ $ucid 	= $suid; } 	
	if($mis || $reg || $guid){
	} else { $ucid 	= $suid; }
	
	$data['ucid'] 	= $ucid;

	$data['mine']	= $mine	= ($ucid==$suid)? true:false;	
	
	$ssy	= $_SESSION['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data['contact'] = $contact = $this->model->contactAttendance($dbg,$sy,$ucid,$fields="");	
	$data['empl']	 = $empl	= ($contact['role_id']==RSTUD)? false:true;	
	$_SESSION['attendance_logs'] = "attdlogs/person/$sy/$moid/$ucid";
	$att = ($empl)? 'attendance_employees_logs':'attendance_logs';
	
	$year 	= getSY($sy,$moid);
	$mo	 	= getMonth($db,$moid,$code=true,$dbg);
	$mo 	= ucfirst($mo);
	
	$data['urid'] 	= $urid 		= $contact['role_id'];	
	$data['crid'] 	= $crid 		= $contact['crid'];	

/* -------------------------------------------------------------------------- */	
	$q = "
		SELECT
			cal.*,att.*,att.id AS attid
		FROM {$dbg}.`$att` AS att
			INNER JOIN {$dbg}.05_calendar AS cal ON cal.date = att.date
		WHERE 	att.`contact_id` 	= '$ucid'
			AND  YEAR(att.`date`) 	= '$year'
			AND  MONTH(att.`date`) 	= '$moid'
			AND  DAY(att.`date`)   $compare '16'
		ORDER BY att.`date` DESC		
	"; 
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['attendances'] 		= $sth->fetchAll();
	$data['num_attendances']	= count($data['attendances']);
	$data['yrmonth']			= $year.' - '.$mo;
	$data['months']	= $this->model->fetchRows(DBO.".months",'*');
	
	// pr($emp);
	
	$this->view->render($data,'students/attendanceLogs');
	

}	/* fxn */


private function attduser($ucid){
$dbo=PDBO;
$q = "
	SELECT 
		uc.name AS fullname,uc.code,uc.id AS ucid,uc.role_id,
		r.name AS role
	FROM {$dbo}.`00_contacts` AS uc 
		LEFT JOIN {$dbo}.`00_roles` AS r ON r.id = uc.role_id
	WHERE uc.`id` = '$ucid' LIMIT 1;
";
$sth = $this->model->db->querysoc($q);
return $sth->fetch();

}	/* fxn */


public function attd($params=NULL){
$dbo=PDBO;
$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	

$sesu  = $_SESSION['user'];
$data['home']		 = $home	= $_SESSION['home'];
$data['today']		 = $today 	= $_SESSION['today'];
$data['suid']		 = $suid  	= $sesu['pcid'];
$data['srid'] 		 = $srid	= $sesu['role_id'];
$data['is_employee'] = $is_employee  	= ($sesu['role_id']==RSTUD)? false:true;

$data['mis']	= $mis 	= ($srid==RMIS)? true:false;
$data['reg']	= $reg 	= ($srid==RREG)? true:false;
$data['guid']	= $guid 	= ($srid==RGUID)? true:false;

if($is_employee){
	$ucid  = isset($params[0])? $params[0]:$suid;
	if($mis || $reg || $guid){
	} else { $ucid = $suid; }	
	$user  = ($ucid==$suid)? $sesu:$this->attduser($ucid);
	// echo ($ucid==$suid)? "sesu":"profile";
} else {
	$ucid  = $suid;
	$user  = $sesu;	
}



$data['user'] = $user;
$data['ucid'] = $ucid;
$data['urid'] = $user['role_id'];
$data['role'] = $user['role'];

$data['date']	= $date  = isset($params[1])? $params[1]:$today;
$tbl   = ($user['role_id']==RSTUD)? 'attendance_logs':'attendance_employees_logs';
$dbg   = PDBG;


$q = " SELECT * FROM {$dbg}.{$tbl} WHERE `contact_id` = '$ucid' AND `date` = '$date' LIMIT 1; ";

$sth = $this->model->db->querysoc($q);
$data['attd'] = $sth->fetch();

$this->view->render($data,'my/attd');


}	/* fxn */




public function dropAttendance($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	if(isset($_POST['submit'])){
		$rows = $_POST['da'];	
		$q = ""; 
		foreach($rows AS $row){ 
			$q .= " DELETE FROM {$dbg}.05_attendance_logs WHERE `date` = '".$row['date']."';  "; 
		}
		$this->model->db->query($q);
		Session::set('message','Dropped date '.$row['date']);
		redirect('mis/dropAttendance');
	}	/* post */

$data['months']	=	$this->model->fetchRows("".PDBO.".months");
$this->view->render($data,'mis/dropAttendance');

}	/* fxn */


public function editAttendanceLog($params){
	$dbo=PDBO;
	$data['home']	= $_SESSION['home'];
	$data['ssy']	= $ssy	 = $_SESSION['sy'];
	$data['sy']		= $sy	 = $params[0];
	$data['attid']	= $attid = $params[1];
	$data['empl']	= $empl	 = isset($params[2])?$params[2]:0;

	$data['dbg']	= $dbg 	= ($sy==$ssy)? DBG:$sy.US.DBG;
	$data['dbm']	= $dbg 	= ($sy==$ssy)? DBM:$sy.US.DBG;
	$att	= ($empl)? 'attendance_employees_logs':'attendance_logs';

	if(isset($_POST['submit'])){
		$attr	= $_POST['att']; 
		$attid  = $attr['id'];
		$this->model->db->update("{$dbg}.`$att`",$attr,"`id`= '".$attid."'");
		$url = isset($_SESSION['attendance_logs'])? $_SESSION['attendance_logs']:'index';
		redirect($url);
		exit;
	}	/* post */

	/* ---------------------------- process ----------------------------   */
	$q	= " SELECT att.*,c.code,c.name,ats.timein AS casti,ats.timeout AS casto
			FROM  {$dbg}.`$att` AS att
				LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id = att.contact_id
				LEFT JOIN {$dbg}.`attendance_schemas` AS ats ON ats.id = c.attschema_id
			WHERE att.id = '$attid' LIMIT 1;
	";
	// pr($q);
	$sth	= $this->model->db->querysoc($q);
	$data['attendance']	= $sth->fetch();

	$this->view->render($data,'mis/editAttendanceLog');

}	/* fxn */




public function attdes($params=NULL){

require_once(SITE."functions/classrooms.php");	
require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['crid']	= $crid	= $params[0];
$data['date']	= $date = isset($params[1])? $params[1]:$_SESSION['today'];
$dbo=PDBO;
$dbg = PDBG;

$q = "
	SELECT 
		c.parent_id pcid,b.*,c.name AS contact
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
		LEFT JOIN (
			SELECT att.* FROM {$dbg}.05_attendance_logs AS att WHERE att.date = '$date'
		) AS b ON b.contact_id = c.id
	WHERE 
			summ.crid = '$crid'	
		AND c.is_active = '1'	
		AND c.id = c.parent_id	
	ORDER BY c.name
;";
// pr($q);

$data['q']=$q;
$sth = $this->model->db->querysoc($q);
$data['attd'] = $sth->fetchAll();
$data['count'] = count($data['attd']);

$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
$data['classrooms'] = getClassroomsButTmp($db,$dbg);

$this->view->render($data,'attdlogs/attdes');

}	/* fxn */








}	/* AttdlogsController */
