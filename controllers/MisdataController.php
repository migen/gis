<?php
Class MisdataController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	/* 2nd param is strict,default is false */	
	$acl = array(array(5,0));
	$this->permit($acl);				
}	/* fxn */


public function index(){	
	$data=NULL;
	$this->view->render($data,'misdata/indexMisdata');
	
	
}	/* fxn */



public function classlist($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/classlists.php');
	require_once(SITE.'functions/classrooms.php');
	$this->view->css=array('bootstrap.min.css');	
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$cr = $data['cr'] = getClassroomDetails($db,$crid,$dbg,$ctp=true);				
	
	$order=$_SESSION['settings']['classlist_order'];
	$order=isset($_GET['order'])? $_GET['order']:$order;
	debug($order,"Order: ");
	$fields='c.is_active,';
	$cond=NULL; 
	if(isset($_GET['active'])){ $cond="AND c.is_active=1"; }
	$q=" SELECT $fields summ.scid,c.code,c.name,c.is_male,c.position,c.lrn,c.sy AS ensy,ctp.ctp,c.account
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id
		WHERE summ.crid='$crid' $cond
		ORDER BY $order;";		
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	$vfile="misdata/classlistMisdata";
	vfile($vfile);
	$this->view->render($data,$vfile);	
	
	
}	/* fxn */



 
} 	/* MisController */

