<?php

Class RegistrationController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index(){ 
$dbo=PDBO;
	$data['home']	= $_SESSION['home'];	
	
	$this->view->render($data,'registration/indexRegistration');
}	/* fxn */

public function sessionizeHome(){
	$_SESSION['home']='registration';
	$_SESSION['user']['home']='registration';
	redirect('registration');
}


public function one($params=NULL){
$dbo=PDBO;
$srid=$_SESSION['srid'];if($srid==RSTUD){ pr("<h3 style='color:brown;'>Student cannot register.</h3>"); exit; }
require_once(SITE."functions/dbyrFxn.php");
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/classrooms.php");
require_once(SITE."functions/registration.php");
 
$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
$sy=DBYR;
$_SESSION['url']="registration/one";
if(isset($_POST['submit'])){
	$vars['today']=$_SESSION['today'];
	$vars['title_id']=1;$vars['role_id']=1;$vars['privilege_id']=1;	
	$vars['pcid']=lastContactId($db,$dbg);
	$row=$_POST['post'];
	$row['acid']=0;
	$vars['pcid']++;
	
	/* 1 purge student */
	$q=qryPurgeStudent($db,$dbg,$vars,$row,$sy);		
	$db->query($q);
	
	/* 2 */
	
	$q = qryRegister($db,$dbg,$vars,$row,$sy);	
	// pr($q);exit;
	$db->query($q);
	$url="registration/one";
	$fullname=$row['fullname'];
	flashRedirect($url,$fullname.' registered.');	
	exit;
}	/* post */

$vfile="registration/oneRegistration";vfile($vfile);
$last_id=lastId($db,"{$dbo}.`00_contacts`");
$data['scid']=$last_id+1;
$this->view->render($data,$vfile);

}	/* fxn */







}	/* RegistrationController */
