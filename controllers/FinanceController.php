<?php

Class FinanceController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	$data=NULL;
	$vfile="finance/indexFinance";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */




public function rar($params=NULL){	
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['dept']=$dept=isset($_GET['dept'])? $_GET['dept']:'gs';
	$data['sch']=$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	require_once(SITE."functions/financeFxn.php");
	$dataget=getPreviousBalance($db,$sy,$dept);
	$data=array_merge($data,$dataget);
	$vfile="finance/rarFinance";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function search(){
	// require_once(SITE."functions/searchFinanceFxn.php");
	
	if(isset($_GET['search'])){
		$get=$_GET;
		$search=$get['search'];
		$db=&$this->baseModel->db;
		
		
		exit;
	}	/* fxn */
	
	$data=isset($data)? $data:NULL;
	$vfile="finance/searchFinance";
	$this->view->render($data,$vfile);
}	/* fxn */







}	/* BlankController */
