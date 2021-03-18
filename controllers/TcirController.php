<?php

Class TcirController extends Controller{	

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
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$sqtr;

$data['srid']=$srid=$_SESSION['srid'];
$home=$_SESSION['home'];

$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
if($srid==RTEAC && $_SESSION['user']['privilege_id']>0){ flashRedirect($home); }
if(!in_array($srid,$allowed)){ flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

if(isset($_GET['sch']) || isset($params[0])){
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$dbo=VCPREFIX."dbone_{$sch}";$dbg=VCPREFIX.$sy."_dbgis_{$sch}";
	$data['classrooms'] = getCirList($db,$dbg,$cond=NULL);
} else {
	$data['classrooms'] = sessionizeCirList($_GET,$db,$dbg);
}
$data['count'] = count($data['classrooms']);
$view=isset($_GET['sch'])? "tcir/indexCirSch":"tcir/indexTcir";
$this->view->render($data,$view);

}	/* fxn */



public function reset(){
	if(isset($_SESSION['cirlist'])){ unset($_SESSION['cirlist']); }
	if(isset($_SESSION['cirlist_all'])){ unset($_SESSION['cirlist_all']); }
	flashRedirect('cir','CIR List reset.');	
}	/* fxn */





}	/* CirController */
