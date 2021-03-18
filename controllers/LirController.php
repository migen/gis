<?php

Class LirController extends Controller{	

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
require_once(SITE."functions/lir.php");	
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];

$allowed = array(RMIS,RREG,RACAD,RADMIN);
$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
$fields="id,code,name";$order="id";$where="WHERE `id`<16";
$data['rows'] = fetchRows($db,"{$dbo}.`05_levels`",$fields,$order,$where);
$data['count'] = count($data['rows']);
$vfile="lir/indexLir";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function reset(){
	if(isset($_SESSION['cirlist'])){ unset($_SESSION['cirlist']); }
	if(isset($_SESSION['cirlist_all'])){ unset($_SESSION['cirlist_all']); }
	flashRedirect('cir','CIR List reset.');	
}	/* fxn */





}	/* CirController */
