<?php

Class SoasController extends Controller{	

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





public function soa($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/fees.php");
require_once(SITE."functions/feesFxn.php");
$data['scid'] = $scid = isset($params[0])? $params[0]:false;
$sy = isset($params[1])? $params[1]:DBYR;
$sy = isset($_GET['psy'])? $_GET['psy']:$sy; 
$data['sy'] = $sy;
$db =& $this->model->db;
$dbg = VCPREFIX.$sy.US.DBG;

$data['lvl'] = $lvl = isset($_GET['lvl'])? $_GET['lvl']:false;
$data['crid'] = $crid = isset($_GET['crid'])? $_GET['crid']:false;

$mode = isset($_GET['mode'])? "AND tsum.paymode_id = ".$_GET['mode']:false;

$data['today'] = $today = $_SESSION['today'];
$data['year'] = $year = $_SESSION['year'];
$data['moid'] = $moid = $_SESSION['moid'];
$data['fdm'] = $fdm = $year.'-'.$moid.'-01';
$data['timestamp'] = $timestamp = date('Y-m-d H:i:s');
$data['cutoff'] = $data['ldm'] = $ldm  = isset($_GET['due'])? $_GET['due'] : $today;


$paymonth = payMonth($ldm);
if($mode){
	$row = fetchRow($db,"{$dbo}.`03_paymodes`",$_GET['mode']);
	$periods = $row['periods'];
	$payPeriod = getPeriod($periods,$ldm);	
} else {
	$payPeriod = $paymonth;	
}	/* mode */
$intrate = $_SESSION['settings']['intrate'];	
 $_SESSION['tfeeid'] = isset($_SESSION['tfeeid'])? $_SESSION['tfeeid'] : feecode_id($db,'tfee');
$data['tfeeid'] = $tfeeid = $_SESSION['tfeeid']; 		



if(!$scid){ updateLevelBalances($db,$lvl); } else {
	updateStudentBalances($db,$scid); }


/* 2 classlist from contacts not tsum, no history required */

$q = "SELECT 
		cr.num,c.is_active,c.id AS scid,c.code AS studcode,c.name AS student,
		tsum.scid AS tsumscid,tsum.*,tsum.remarks AS tsumremarks,
		pm.*,pm.name AS paymode,pm.code AS paymode_code,pm.count AS numperiods,pm.dates AS paydates,
		cr.id AS crid,cr.name AS classroom,cr.level_id
	FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		LEFT JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid = summ.scid
		LEFT JOIN {$dbo}.`03_paymodes` AS pm ON tsum.paymode_id = pm.id
";

if($scid){
	$where = "summ.scid='$scid'";	
} elseif($crid){
	$where = "cr.id = '$crid' AND c.`sy` <> '".(DBYR+1)."' AND c.is_enrolled=1 $mode ";	
}else {
	$where = "cr.level_id = '$lvl' AND cr.section_id<>2 AND c.`sy` <> '".(DBYR+1)."' AND c.is_enrolled=1 AND c.is_active=1 $mode ";
}

// pr($where);
// pr($crid);

// $dropped = (isset($_GET['all']))? NULL:'AND c.is_active=1';
$q .= " WHERE $where  ORDER BY c.name; ";
$data['q']=$q;
// debug($q);

$sth = $this->model->db->querysoc($q);
$data['students'] = $students = $sth->fetchAll();
$data['num_students'] = count($students);

if($scid){ $lvl = $students[0]['level_id']; 
	$payPeriod = getPeriod($students[0]['periods'],$ldm);
	$num=$students[0]['num'];
} elseif($crid){
	$classroom = getClassroomDetails($db,$crid,$dbg);
	$lvl = $classroom['level_id'];	
	$num = $classroom['num'];	
} 


$data['payPeriod'] = ($payPeriod)? $payPeriod:$paymonth;
$num = isset($num)? $num:1;
$data['num'] = $num;
/* 2 tuition */ 
$data1 = levelTuition($db,$lvl,$num,$dbg);
$data = array_merge($data,$data1);
$data['tuitions'] = fees($db,$lvl,$num,$dbg);

/* 3 payables - a) assessments and b) addons */
$data2 = soaData($db,$students,$tfeeid,$dbg);
$data = array_merge($data,$data2);

$data['paymodes'] = $paymodes = $this->model->fetchRows("{$dbo}.`03_paymodes`","*","id");
$_SESSION['levels'] = isset($_SESSION['levels'])? 
	$_SESSION['levels']:$this->model->fetchRows("{$dbo}.`05_levels`","id,name","id"); 
$data['levels'] = $_SESSION['levels'];
$_SESSION['classrooms'] = isset($_SESSION['classrooms'])? 
	$_SESSION['classrooms']:$this->model->fetchRows("{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 
$data['classrooms'] = $_SESSION['classrooms'];	

$data['contacts'] = NULL;
$data['page'] = "Statement of Account";	

$this->view->render($data,"soas/soa");

}	/* fxn */







}	/* SoasController */
