<?php

Class LockersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$acl = array(array(9,0),array(5,0),array(6,0),array(7,0));
	$this->permit($acl,$strict=false);		

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}



public function index(){
	echo "Lockers index";
}


public function course($params){
$dbo=PDBO;
	require_once(SITE.'functions/advcrsLocks.php');
	$db=&$this->model->db;$dbg=PDBG;
	$data['crs']=$crs=$params[0];
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	$srid=$_SESSION['srid'];
	$ucid=$_SESSION['ucid'];
	$data['row']=$row=lockerCourse($db,$dbg,$crs);
	// pr($row);
	if($srid==RTEAC){ if($row['acid']!=$ucid){ flashRedirect(UNAUTH,'Only adviser allowed.');  }	 }
	$this->view->render($data,'locking/courseLocks');
}	/* fxn */




}	/* BlankController */
