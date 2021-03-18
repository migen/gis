<?php


Class EmployeesController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	

	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(9,0),array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		

	
}

public function beforeFilter(){ parent::beforeFilter();		}	


public function photos($params=NULL){
$data['role_id']	= $role_id = isset($params[0])? $params[0]:NULL;
$cond = isset($params[0])? " AND c.role_id = $role_id":NULL;
$db = $this->model->db;
$dbg = PDBG;
$dbo=PDBO;$dbp=PDBP;

$q = "
	SELECT 
		c.id AS ucid,c.parent_id AS pcid,c.*,ph.photo,ph.id AS photo_id,r.name AS role
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbp}.photos AS ph ON ph.contact_id = c.id
		LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
	WHERE 	(c.id=c.parent_id) AND c.role_id <> ".RSTUD."	$cond 
		ORDER BY c.role_id,c.name
	;			
	
";

// $_SESSION['q'] = $q;
$data['q'] = $q;
$sth = $db->querysoc($q);
$data['employees']	= $sth->fetchAll();
$data['count']	= count($data['employees']);
$data['roles']	= $this->model->fetchRows($dbo.'.`00_roles`');

$_SESSION['url'] = "employees/photos/$role_id";

$this->view->render($data,'employees/photos');




}	/* fxn */




public function index($params=NULL){
$db=&$this->baseModel->db;
include_once(SITE.'views/elements/params_sq.php');
		
if(isset($_POST['add'])){
	// pr($_POST);
	$year 		   = date('Y');
	$pass		   = MD5('pass');	
	$rows 		   = $_POST['contacts'];
	
	$q = " SELECT max(id) AS cid FROM {$dbo}.`00_contacts`;";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$cid = $row['cid'];
	
	$q = "";
 	foreach($rows AS $row){
		$cid++;
		$fullname = $row['last'].','.$row['first'].' '.$row['middle'];
		
		/* 1-contacts_tbl */
		$q .= " INSERT INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`code`,
			`account`,`pass`,`is_active`,`title_id`,`role_id`,`privilege_id`,`sy`,`is_male`) VALUES 
			('$cid','$cid','$fullname','".$row['code']."',
			'".$row['code']."','$pass','1','".$row['title_id']."','".$row['role_id']."','".$row['privilege_id']."','$year','".$row['is_male']."'); ";
		
		/* 1b - ctp */
		$q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`,`ctp`) VALUES ('".$cid."','pass'); ";
		
		/* 2-profiles_tbl */
		$q .= "INSERT INTO {$dbo}.`00_profiles` (`contact_id`,`first_name`,
			`middle_name`,`last_name`) VALUES			
			('$cid','".$row['first']."','".$row['middle']."',
			'".$row['last']."');
		";
			
	}	/* foreach */
	
	$db->query($q);
	redirect('mis');
	
}	/* post-add */

	$data['titles']		= $_SESSION['titles'];
	$this->view->render($data,'employees/index');

}	/* fxn */




public function getEmployee($params=NULL){
	include_once(SITE.'views/elements/params_sq.php');
	
	$ecode = $_POST['ecode'];
	$q = " SELECT id AS ecid,name FROM {$dbo}.`00_contacts` WHERE `role_id` != '1' AND (id=parent_id) AND `code` = '$ecode' LIMIT 1;	";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
}	/* fxn */




public function view($params){
	$ecid = $params[0];
	$ssy	= $_SESSION['sy'];
	$sy 	= isset($params[1])? $params[1]: $ssy;

	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$q = "SELECT c.*,c.name AS employee,c.id AS ecid,p.*,e.*,t.name AS title,ctp.ctp 
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbg}.06_employees AS e ON e.contact_id = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		WHERE c.id = '$ecid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$data['employee'] = $sth->fetch();
	$this->view->render($data,'employees/view');
	

}	/* fxn */



public function attemps($params=NULL){	/* role */
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/employees.php");	
	$db =& $this->model->db;

	$role_id	= $data['role_id'] = isset($params[0])? $params[0] : 0; 
	$ssy 		= $data['ssy'] = $_SESSION['sy'];
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$emp		= isset($params[3])? $params[3]:true;
	$att 		= ($emp)? 'attendance_employees_logs':'attendance_logs';
	
	$dbg	= VCPREFIX.$sy.US.DBG;
	$role	= $this->model->fetchRow("".PDBO.".`00_roles`",$role_id);
	
/* ---------------------- process ----------------------------------------------------------------	 */


	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields=NULL,$filter);
	$data['num_emps'] = count($data['emps']);		
	$data['numrows'] = $numrows = $data['num_emps'];
	if($numrows==0){ $this->flashRedirect("mis/attemps/0/$sy","No record found for ".$role['name']); }
		
	$months = $data['months'] = gisMonthsQuarters($db,$qtr,$dbg);
	$data['attendance_months'] 	= employeesAttendanceMonths($db,$sy,$dbg);	 	 
	$data['roles'] = $this->model->fetchRows("".PDBO.".`00_roles`");
	
	foreach($data['emps'] AS $row){ $data['attendance'][] = getEmployeeAttendance($db,$dbg,$sy,$row['ecid']); }	

	$data['today']		= $_SESSION['today'];	
	$data['home'] = 'mis';
	$_SESSION['attendance_url'] = URL.'mis/attEmps/'.$role_id.DS.$sy.DS.$qtr;
	
	$this->view->render($data,'employees/attemps');

		 
 
}	/* fxn */




public function attendance($params=NULL){		/* role */
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$dbg = PDBG;
	$dbg = PDBG;
	
	$role_id	= $data['role_id'] = isset($params[0])? $params[0] : 0; 
	$sy 		= $data['sy'] = $_SESSION['sy'];
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	

	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields=NULL,$filter);
	$data['num_emps'] = count($data['emps']);		
		
	$months = $data['months'] 	= gisMonthsQuarters($db,$qtr);
	$data['attendance_months'] 	= employeesAttendanceMonths($db,$sy,$dbg);	 	 
	$data['roles'] = $this->model->fetchRows("".PDBO.".`00_roles`");
		
	foreach($data['emps'] AS $row){ $data['attendance'][] = getEmployeeAttendance($db,$dbg,$sy,$row['ecid']); }
		
	$data['today']	= $_SESSION['today'];	
	$data['home'] 	= $_SESSION['home'];
	$_SESSION['attendance_url'] = URL."mis/attEmps/$role_id/$sy/$qtr";
	
	$this->view->render($data,'employees/attendance');

		
 
 
}	/* fxn */




public function talAttemps($params){	/* tally attendance logs */

include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/codes.php");
require_once(SITE."functions/attendance.php");
require_once(SITE."functions/employees.php");
$db =& $this->model->db;


$month_id 	= $params[2];
$role_id 	= $params[3];

$mc			= getMonthCode($db,$month_id);
$mc			= strtolower($mc);

$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
$fields = " ats.*,";
$data['emps'] 	  = employees($db,$dbg,$fields,$filter);

$data['attendances'] = array();
$i=0;

if($month_id < $_SESSION['settings']['month_start']){ $year = $sy+1; }

foreach($data['emps'] AS $row){

	$data['attendances'][$i]['ecid'] 	= $row['ecid'];	
	$data['attendances'][$i][$mc.'_days_present'] = talpre($db,$dbg,$row['ecid'],$year,$month_id,$emps=true);	
	$data['attendances'][$i][$mc.'_days_tardy']   = taltar($db,$dbg,$row['ecid'],$year,$month_id,$row['timein'],$row['timeout']);	
	$data['attendances'][$i][$mc.'_minutes_tardy']   = talmin($db,$dbg,$row['ecid'],$year,$month_id,$row['timein'],$row['timeout']);	

	$i++;	
}	/* fxn */


$q = "";
foreach($data['attendances'] AS $row){
	$q .= " UPDATE {$dbg}.06_attendance_employees SET `".$mc."_days_present` = '".$row[$mc.'_days_present']."',
			`".$mc."_days_tardy` = '".$row[$mc.'_days_tardy']."',
			`".$mc."_minutes_tardy` = '".$row[$mc.'_minutes_tardy']."'
			WHERE `ecid` = '".$row['ecid']."' LIMIT 1; ";
			
}

// pr($q); exit;

	$this->model->db->query($q);
	
	$url = "mis/attemps/$role_id/$sy/$qtr";
	// pr($q); pr($url); exit;
	
	redirect($url);

}	/* fxn */


public function dailyAttemps($params){
	$role_id		= $params[0];	
	$date			= $params[1];	
	$sy	= $data['sy'] = $_SESSION['sy'];
	$data['role_id'] = $role_id;
	$dbg = PDBG;
	
/* --------------------------------------------------------------------------	 */	
	$role = ($role_id>0)? "c.`role_id` = '$role_id'" : ' c.`role_id` <> 1 ';

	$q = "
		SELECT			
			c.id AS cid,c.code,c.name AS employee,al.timein,al.timeout
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN (
				SELECT * FROM {$dbg}.06_attendance_employees_logs WHERE `date` = '$date'			
			) AS al	ON al.contact_id = c.id		
		WHERE 	
				$role
			AND  c.`is_active`=1				
			AND  c.id=c.parent_id										
			AND  c.`id`<>1							
		GROUP BY c.`id`
		ORDER BY c.`name` 		
	"; 
 
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['attendances'] 		= $sth->fetchAll();
	$data['num_attendances']	= count($data['attendances']);
	$data['date']				= $date;
	
	$this->view->render($data,'mis/dailyAttemps');
	
}	/* fxn */




public function emplist($params){
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id'] 	= $role_id	=  isset($params[0])? $params[0] : 0; 
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sy']			= $sy		= isset($params[1])? $params[1]:$ssy;

	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$fields = "ctp.ctp,ats.id AS attschema_id,ats.name AS attschema,";
	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields,$filter);
	$data['num_emps'] = count($data['emps']);		
	$_SESSION['photo_url'] = "mis/emplist/".$role_id;
	
	if(isset($_POST['submit'])){
		$rows = $_POST['c'];
		// pr($rows);
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`00_contacts` SET 
				`is_male` 		= '".$row['is_male']."',  
				`is_active` 	= '".$row['is_active']."',  
				`attschema_id` 	= '".$row['attschema_id']."'  
				WHERE `id` = '".$row['cid']."' LIMIT 1; ";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/emplist/$role_id";
		redirect($url);
		// exit;
		
	}
	
	$fields = "*";
	$data['attschemas'] = $this->model->fetchRows("{$dbg}.05_attendance_schemas",$fields);	
	$data['num_attschemas'] = count($data['attschemas']);
	
	$this->view->render($data,'mis/emplist');


}	/* fxn */



public function emplistManager($params){
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id'] 	= $role_id	=  isset($params[0])? $params[0] : 0; 
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sy']			= $sy		= isset($params[1])? $params[1]:$ssy;

	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$fields = "c.parent_id,c.`sy`,c.created_date,ctp.ctp,ats.id AS attschema_id,ats.name AS attschema,";
	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields,$filter);
	$data['num_emps'] = count($data['emps']);		
	$_SESSION['url'] = "mis/emplist/".$role_id;
	
	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$q = $this->deleteEmployees($ids);
		$this->model->db->query($q);
		Session::set('message','Purged Employees Successfully!');
		$url = "mis/emplistManager/$role_id/$sy";
		redirect($url);		
		exit;
	}
	
	if(isset($_POST['save'])){
		// pr($_POST);
		$rows = $_POST['contact'];
		$q = "";
		foreach($rows AS $row){
			$mdpass = MD5($row['pass']);
			$q .= "UPDATE {$dbo}.`00_contacts` SET 
					`is_active` = '".$row['is_active']."',`sy`='".$row['year']."', 
					`code` = '".$row['code']."',`account`='".$row['code']."', 
					`pass` = '".$mdpass."',`name`='".$row['name']."' 
				WHERE `id`='".$row['id']."'; ";
			$q .= "UPDATE {$dbo}.`00_ctp` SET `ctp` = '".$row['pass']."' WHERE `contact_id` = '".$row['id']."'; ";
		}
		$this->model->db->query($q);
		$_SESSION['message'] = 'Changes saved.';
		$url = "mis/emplistManager/$role_id/$sy";
		redirect($url);	
		exit;
	
	}
	
	$this->view->render($data,'mis/emplistManager');


}	/* fxn */


/* c.id,p.contact_id,attempl.ecid,photos.contact_id,ctp.contact_id */
public function deleteEmployees($ids){
$q = "";
$params = explode('/',$ids);

$num_params = count($params);
for($i=0;$i<$num_params;$i++){
	$q .= "DELETE FROM ".PDBG.".attendance_employees WHERE `ecid` = '".$params[$i]."';  ";
	$q .= "DELETE FROM {$dbo}.`00_contacts` WHERE `id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM {$dbo}.`00_profiles` WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM ".DBP.".photos WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM {$dbo}.`00_ctp` WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
}		

return $q;

}	/* fxn */




/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function employer($params=NULL){

require_once(SITE."functions/employees.php");
$db =& $this->model->db;

$data['ecid']	= $ecid	= isset($params[0])? $params[0]:NULL;
$data['ssy'] 	= $ssy	= $_SESSION['sy'];	
$data['sy']		= $sy 	= isset($params[1])? $params[1]:$ssy;
$data['home']	= $home	= $_SESSION['home'];

$dbg	= VCPREFIX.$sy.US.DBG;

if(!empty($params)){ 
	$data['employee'] = $employee = employee($db,$dbg,$ecid); 
	$all = (isset($_GET['all']))? true:false;

}


if(isset($_POST['submit'])){

	$pcid = $employee['pcid'];
	$ucid = $employee['ucid'];
	
	/* 1 - contacts */		
	$q = " UPDATE {$dbo}.`00_contacts` SET 
				`is_active`  = '".$_POST['is_active']."',
				`is_cleared`  = '".$_POST['is_cleared']."',
				`is_male`  = '".$_POST['is_male']."'
			WHERE `id` = '$ecid' LIMIT 1;	";
	/* 2 - summaries for employee? */		
	
	/* echo (isset($employee['sumecid']))? 'sumecid set':'sumecid NOT set'; */
	/* 3 - init students,profiles,photos,ctp if not exists */
	if(!isset($employee['attdecid'])){ $q .= " INSERT INTO {$dbg}.06_attendance_employees (`ecid`) VALUES ('$pcid');  "; }	
	if(!isset($employee['emplecid'])){ $q .= " INSERT INTO {$dbg}.06_employees(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employee['ctpucid'])){ $q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$ucid');  "; }	
	if(!isset($employee['profecid'])){ $q .= " INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employee['photoecid'])){ $q .= " INSERT INTO ".PDBP.".photos(`contact_id`) VALUES ('$pcid');  "; }	
	
	// pr($q); exit;
	$this->model->db->query($q);
	$url = "mis/employer/$ecid";
	$this->flashRedirect($url,"Employee updated.");

}	/* post */


if(isset($_POST['purge'])){ 
	$url = "registrars/purgeContacts/".$ecid;
	redirect($url); exit; 
}	/* post */

/* ---------------------------------------------------------------------------- */

$this->view->render($data,'employees/employer');

}	/* fxn */



public function employing($params){
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id']= $role_id = isset($params[0])? $params[0]:RTEAC;	
	$data['ssy']	= $ssy 	= $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];
	
	$_SESSION['url']	= "mis/employing/$role_id";		
	$data['current'] = $current = ($sy==$ssy)? true : false;	
	$dbg  = VCPREFIX.$sy.US.DBG;	

	// $sort = "c.is_male DESC,c.name";
	$sort = (isset($_GET['sort']))? $_GET['sort']:"c.is_male DESC,c.name";
	$fields=null;
	// $filter = isset($_GET['all'])? NULL:"AND c.`sy`=$sy";
	$filter = null;
	$data['employees'] 	= $employees = employing($db,$dbg,$role_id,$male=2,$sort,$fields,$filter);	
	$data['count']		= count($data['employees']);

	
if(isset($_POST['submit'])){
// pr($_POST);
$posts = $_POST['employees'];
$q = "";
$i=0;
foreach($posts AS $row){
	$pcid = $employees[$i]['pcid'];
	$ucid = $employees[$i]['ucid'];

	/* 1 - contacts */		
	$q .= " UPDATE {$dbo}.`00_contacts` SET 
		`title_id` = '".$row['title_id']."',  
		`role_id` = '".$row['role_id']."',  
		`privilege_id` = '".$row['privilege_id']."',  		
		`is_active` = '".$row['is_active']."',  
		`is_cleared` = '".$row['is_cleared']."',  
		`is_male` 	= '".$row['is_male']."'  
		WHERE `id` = '$ucid' LIMIT 1; ";
		
	/* 2 - summaries */			
	/* echo (isset($employee['sumecid']))? 'sumecid set':'sumecid NOT set'; */
	/* 3 - init students,profiles,photos,ctp if not exists */
	if(!isset($employees[$i]['ctpucid'])){ $q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$ucid');  "; }	
	if(!isset($employees[$i]['attdecid'])){ $q .= " INSERT INTO {$dbg}.06_attendance_employees (`ecid`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['emplecid'])){ $q .= " INSERT INTO {$dbg}.06_employees(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['profecid'])){ $q .= " INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['photoecid'])){ $q .= " INSERT INTO ".DBP.".photos(`contact_id`) VALUES ('$pcid');  "; }	
/* 	if(empty($employees[$i]['name'])){ 
		$q .= " UPDATE {$dbo}.`00_contacts` SET `name` = '".$employees[$i]['parentname']."' WHERE `id` = '$ucid' LIMIT 1;  "; }	
 */		
	
	
	$i++;
}	/* foreach */

$_SESSION['q'] = $q;
// pr($q);exit;
$this->model->db->query($q);

$url = "mis/employing/$role_id";
$this->flashRedirect($url,'Updated employees.');

exit;

}	/* post */

	
	$data['roles'] = $_SESSION['roles'];
	$data['titles'] = $_SESSION['titles'];
	$this->view->render($data,'employees/employing');	

}	/* fxn */


public function codelist(){
$db=&$this->model->db;$dbo=PDBO;
$q=" SELECT id AS ucid,code,name FROM {$dbo}.`00_contacts` WHERE role_id <> '".RSTUD."' 
	AND role_id <> '".RMIS."' AND role_id <> '".RSUPP."' ORDER BY name; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$postcode=$post['code'];
		$q.="UPDATE {$dbo}.`00_contacts` SET `code`='$postcode', 
			`account`='$postcode' WHERE `id`='".$post['ucid']."' LIMIT 1; ";
	}
	$db->query($q);
	flashRedirect('employees/codelist','Codes updated.');
	
}

if(isset($_GET['print'])){
	$this->view->render($data,'employees/codelist_printable');
} else {
	$this->view->render($data,'employees/codelist');
}


}	/* fxn */






} 	/* EmployeesController */
