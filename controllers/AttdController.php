<?php

Class AttdController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "attd index";

}	/* fxn */



/* AdvisersController */
public function tal($params){	/* tally attendance logs,by acid or guidance */
	$dbo=PDBO;
	require_once(SITE."functions/codes.php");
	// require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	$db =& $this->model->db;

	$crid 		= $params[0];
	$sy 		= $data['sy'] = $params[1];
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$home 	 	= $data['home'] = $_SESSION['home'];

	$dbg  = VCPREFIX.$sy.US.DBG;


$month_id 	= $params[3];
$mc			= getMonthCode($db,$month_id,$dbg);
$mc			= strtolower($mc);
$year		= DBYR;


$data['students'] 	= $students = classlistAttschema($db,$dbg,$sy,$crid,$male=2,$order="c.`name`");	

$data['attendances'] = array();
$i=0;
if($month_id < $_SESSION['settings']['month_start']){ $year = DBYR+1; }

foreach($data['students'] AS $row){
	$studtimein=isset($row['timein'])? $row['timein']:'07:00:00';
	$studtimeout=isset($row['timeout'])? $row['timeout']:'16:00:00';
	$data['attendances'][$i]['scid'] 	= $row['scid'];	
	$data['attendances'][$i][$mc.'_days_present'] = talpre($db,$dbg,$row['scid'],$year,$month_id);	
	$data['attendances'][$i][$mc.'_days_tardy']   = taltar($db,$dbg,$row['scid'],$year,$month_id,$studtimein,$studtimein);	
	$i++;
}	

$q = "";
foreach($data['attendances'] AS $row){
	$q .= " UPDATE {$dbg}.05_attendance SET `".$mc."_days_present` = '".$row[$mc.'_days_present']."',
			`".$mc."_days_tardy` = '".$row[$mc.'_days_tardy']."'
			WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
			
}

	$this->model->db->query($q);
	
	$url = "attendance/monthly/$crid/$sy/$qtr";	
	redirect($url);

}	/* fxn */




}	/* AttdController */
