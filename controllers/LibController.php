<?php

Class LibController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;	
	$data['home']	= $_SESSION['home'];
	echo "lib index";
	$this->view->render($data,'tests/index');


}	/* fxn */





public function stats($params=NULL){
require_once(SITE."functions/lib.php");
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
$x=isset($params[0])? $params[0]:$_SESSION['moid'];
$data['moid']=$moid=str_pad($x,2,'0',STR_PAD_LEFT);
$data['moidno']=$x;

$q="SELECT DAY(`date`) AS day FROM {$dbg}.05_calendar WHERE MONTH(`date`)='$moid' ORDER BY date ASC LIMIT 50;";
$sth=$db->querysoc($q);
$data['days']=$days=$sth->fetchAll();
$data['numdays']=count($days);
$data['rmonth']=getMonthDetails($db,$moid);

if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name,department_id AS deptid","id"); }
$data['rlevels']=$rlevels=$_SESSION['levels'];
$levels=buildArray($rlevels,'id');
array_unshift($levels,'0');
$data['levels']=$levels;

$q="SELECT ps.*,l.name AS level 
	FROM {$dbg}.70_patronstats AS ps LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=ps.lvl
	WHERE ps.moid='$moid' ORDER BY ps.lvl ASC; ";
$sth=$db->querysoc($q);
$rows = $sth->fetchAll();
$data['rows']=$rows;

$year=$_SESSION['sy'];
if($moid < $_SESSION['settings']['month_start']){ $year+=1; } 
$data['year']=$year;
$data['today']=$today=$_SESSION['today'];
$data['day_current']=$day_current=date('d',strtotime($today));
$data['date_report']=$date_report=$year.'-'.$moid.'-'.$day_current;

$this->view->render($data,'lib/stats');

}	/* fxn */



public function updateLvlPatronStats($params=NULL){
	require_once(SITE."functions/lib.php");
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;

	$data['lvl']=$lvl=isset($params[0])?$params[0]:4;
	$x=isset($params[1])?$params[1]:$_SESSION['moid'];
	$data['moid']=$moid=str_pad($x,2,'0',STR_PAD_LEFT);
	$date=$_SESSION['today'];
	ulps($db,$moid,$lvl);

}	/* fxn */



public function updateLvlPatronStatsLoopLevels($params=NULL){
require_once(SITE."functions/lib.php");
$db=&$this->model->db;

$x=isset($params[0])?$params[0]:$_SESSION['moid'];
$data['moid']=$moid=str_pad($x,2,'0',STR_PAD_LEFT);

/* 1 */
$levels=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
foreach($levels AS $lvl){
	ulps($db,$moid,$lvl);	
}

}	/* fxn */



public function updateLvlPatronStatsEmployees($params=NULL){
	require_once(SITE."functions/lib.php");
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;

	$data['lvl']=$lvl=0;
	$x=isset($params[1])?$params[1]:$_SESSION['moid'];
	$data['moid']=$moid=str_pad($x,2,'0',STR_PAD_LEFT);
	$date=$_SESSION['today'];
	ulpsEmployees($db,$moid,$lvl);

}	/* fxn */



public function updatePatronStatsDaily($params=NULL){
	require_once(SITE."functions/lib.php");
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;
	$data['date']=$date=isset($params[0])?$params[0]:$_SESSION['today'];
	upsd($db,$date);

}	/* fxn */








}	/* LibController */
