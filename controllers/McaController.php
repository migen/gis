<?php

Class McaController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$data['levels']=$_SESSION['levels'];
	$data['num_levels']=count($data['levels']);
	$this->view->render($data,'mca/indexMca');
}	/* fxn */



public function locking($params=NULL){	
	$dbo=PDBO;	
	require_once(SITE."functions/mca.php");
	require_once(SITE."functions/levels.php");
	$level_id=isset($params[0])? $params[0]:4;
	$data['home']=$_SESSION['home'];
	$data['sy']=$sy=isset($params[1])? $params[1]: DBYR;
	$data['qtr'] = $qtr = isset($params[2])? $params[2]: $_SESSION['qtr'];
	$data['final']	 	= ($qtr>4)? true:false;
	$data['intfqtr']	= ($qtr==6)? 6:5;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
		
	if($level_id){		
		$data['crs'] = cq($db,$level_id,$cond=1,$dbg);		
		$data['adv'] = aq($db,$level_id,$cond=1,$dbg);						
	}			
	$data['level'] = getLevel($db,$level_id,$dbg);	
	$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",'id,code,name','id');	
	$vfile='mca/locking';vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */

























}	/* McaController */
