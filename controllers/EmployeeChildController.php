<?php

Class EmployeeChildController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();

	$acl = array(array(2,0),array(5,0),array(9,0));
	$this->permit($acl,false);		
	
}	/* fxn */


public function index($params=NULL){	
	$db=&$this->baseModel->db;
	$dbo=PDBO;$data['sy']=DBYR;
	require_once(SITE."functions/numberFxn.php");

	$this->view->render($data,"abc/index");

}	/* fxn */



public function status($params=NULL){
$data['scid']=$scid=(isset($params[0]))? $params[0]:false;
$data['sy']=$sy=(isset($params[1]))? $params[1]:$_SESSION['settings']['sy_enrollment'];
$dbo=PDBO;$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];
if($scid){
	$q="SELECT c.code AS studcode,c.name AS studname,c.is_employee_child 
		FROM {$dbo}.`00_contacts` AS c 
		WHERE c.`id`='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];	
	$row=$_POST['post'];	
	// prx($row);
	$db->update("{$dbo}.`00_contacts`",$row,"`id`='$scid'"); 
	$msg="Success.";
	flashRedirect("employeeChild/status/$scid",$msg);
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'employeeChild/statusEmployeeChild');	/* from codename/one */

}	/* fxn */






}	/* BlankController */
