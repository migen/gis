<?php

Class UcirController extends Controller{	

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

require_once(SITE."functions/ucirFxn.php");	
$data['dbyr']=$dbyr=DBYR;
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[0])? $params[0]:$dbyr;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$sqtr;

$allowed = array(RMIS,RREG,RACAD,RADMIN);

$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
 
$d=getUcirList($db,$dbg);
$data['rows']=$d['rows'];
$data['count']=$d['count'];


$vfile="ucir/indexUcir";
$this->view->render($data,$vfile);

}	/* fxn */



public function reset(){
	if(isset($_SESSION['ucirlist'])){ unset($_SESSION['ucirlist']); }
	if(isset($_SESSION['ucirlist_all'])){ unset($_SESSION['ucirlist_all']); }
	flashRedirect('ucir','UCIR List reset.');	
}	/* fxn */











}	/* BlankController */
