<?php

Class CcirController extends Controller{	

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
require_once(SITE."functions/ccirFxn.php");	
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

/* 
if(isset($_GET['sch']) || isset($params[0])){
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$dbo=VCPREFIX."dbone_{$sch}";$dbg=VCPREFIX.$sy."_dbgis_{$sch}";
	$data['rows'] = getCirList($db,$dbg,$cond=NULL);
} else {
	$data['rows'] = sessionizeCirList($_GET,$db,$dbg);	
}
 */

 
 
 
 
$d=getCcirList($db,$dbg);
$data['rows']=$d['rows'];
$data['count']=$d['count'];


// $view=isset($_GET['sch'])? "cir/indexCirSch":"cir/indexCir";
$vfile="ccir/indexCcir";
// pr($data);exit;
$this->view->render($data,$vfile);

}	/* fxn */



public function reset(){
	if(isset($_SESSION['cirlist'])){ unset($_SESSION['cirlist']); }
	if(isset($_SESSION['cirlist_all'])){ unset($_SESSION['cirlist_all']); }
	flashRedirect('cir','CIR List reset.');	
}	/* fxn */





}	/* CirController */
