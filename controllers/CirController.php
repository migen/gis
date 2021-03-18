<?php

Class CirController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/cir.php");	
$data['ssy']=$ssy=DBYR;
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[0])? $params[0]:$ssy;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$sqtr;

$allowed = array(RMIS,RREG,RACAD,RADMIN);

$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;


if($_SESSION['settings']['is_cluster']){
	$brid=$_SESSION['brid'];	
	if(isset($_GET['all'])){
		$data['rows'] = getCirList($db,$dbg,$cond=NULL);
	} else if(isset($_GET['tmp'])){
		unset($_SESSION['cirlist']);unset($_SESSION['cirlist_all']);
		$data['rows'] = getCirList($db,$dbg,$cond="WHERE cr.branch_id=$brid");	
	} else {	
		$cond="WHERE cr.branch_id=$brid AND cr.section_id > 2";				
		$data['rows'] = sessionizeCirListByBrid($_GET,$db,$dbg,$cond);		
	}			
} else {
	if(isset($_GET['sch']) || isset($params[0])){
		$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
		$dbo=VCPREFIX."dbone_{$sch}";$dbg=VCPREFIX.$sy."_dbgis_{$sch}";
		$data['rows'] = getCirList($db,$dbg,$cond=NULL);
	} else {	
		if(isset($_GET['debug'])){
			$data['rows'] = getCirList($db,$dbg,$cond=NULL);			
		} else {		
			$data['rows'] = sessionizeCirList($_GET,$db,$dbg);			
		}
	}	
}

$data['count'] = count($data['rows']);
$view=isset($_GET['sch'])? "cir/indexCirSch":"cir/indexCir";
if(isset($_GET['ext'])){ $view="cir/extCir"; }
vfile($view);
$this->view->render($data,$view);

}	/* fxn */



public function cert($params=NULL){
require_once(SITE."functions/cir.php");	
$data['ssy']=$ssy=DBYR;
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[0])? $params[0]:$ssy;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$sqtr;

$allowed = array(RMIS,RREG,RACAD,RADMIN);

$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;


if(isset($_GET['sch']) || isset($params[0])){
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$dbo=VCPREFIX."dbone_{$sch}";$dbg=VCPREFIX.$sy."_dbgis_{$sch}";
	$data['rows'] = getCirList($db,$dbg,$cond=NULL);
} else {
	$data['rows'] = sessionizeCirList($_GET,$db,$dbg);
	
}
$data['count'] = count($data['rows']);
$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$view=isset($_GET['sch'])? "cir/indexCertCirSch":"cir/certCir";

$this->view->render($data,$view);

}	/* fxn */






public function reset(){
	if(isset($_SESSION['cirlist'])){ unset($_SESSION['cirlist']); }
	if(isset($_SESSION['cirlist_all'])){ unset($_SESSION['cirlist_all']); }
	flashRedirect('cir','CIR List reset.');	
}	/* fxn */



public function links($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

	if($crid){
		require_once(SITE.'functions/details.php');
		$data['classroom']=getClassroomDetails($db,$crid,$dbg);
		
	}	/* crid */
	
	
	
	$vfile="cir/linksCir";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */






}	/* CirController */
