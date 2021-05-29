<?php

Class CodenameController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$acl = array(array(RMIS,0),array(RAXIS,0),array(RREG,0));	
	/* 2nd param is strict,default is false */	
	$this->permit($acl,0);				
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Codename index";

}	/* fxn */




public function one($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/contactsFxn.php');
$data['id']=$id=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];

if($id){
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];	
	$row=$_POST['post'];	
	$account=$row['account'];
	$available=validateAccount($db,$account);
	if(!$available){ $db->update("{$dbo}.`00_contacts`",$row,"`id`='$id'"); 
		$msg="Updated.";
	} else { $msg="Login Account already taken. Try another."; }
	flashRedirect("codename/one/$id",$msg);
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'codename/oneCodename');	/* from codename/one */

}	/* fxn */


public function name($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/contactsFxn.php');
$data['id']=$id=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];
if($id){
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];	
	$row=$_POST['post'];	
	$account=$row['account'];
	$db->update("{$dbo}.`00_contacts`",$row,"`id`='$id'"); 
	flashRedirect("codename/name/$id",$msg);
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'codename/nameCodename');	/* from codename/one */

}	/* fxn */



public function fullname($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/contactsFxn.php');
$data['id']=$id=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;$dbo=PDBO;
$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];
if($id){
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];	
	$row=$_POST['post'];	
	$db->update("{$dbo}.`00_contacts`",$row,"`id`='$id'"); $msg="Updated."; 
	flashRedirect("codename/fullname/$id",$msg);
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'codename/fullnameCodename');	/* from codename/one */

}	/* fxn */




public function student($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/contactsFxn.php');
$data['id']=$id=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];
if($id){
	
	$fc="id,parent_id,code,name,account";
	$fp="id,contact_id,first_name,middle_name,last_name";
	$data['contact']=fetchRow($db,"{$dbo}.00_contacts",$id,$fc);
	$data['profile']=fetchRecord($db,"{$dbo}.00_profiles","contact_id=$id",$fp);

	// prx($data);
	
}

if(isset($_POST['submit'])){
	$contact=$_POST['contact'];	
	$profile=$_POST['profile'];	
	$db->update("{$dbo}.`00_contacts`",$contact,"`id`='$id'"); 
	$db->update("{$dbo}.`00_profiles`",$profile,"`contact_id`='$id'"); 
	$msg="SCN updated.";
	flashRedirect("codename/student/$id",$msg);
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$vfile='codename/studentCodename';vfile($vfile);
$this->view->render($data,$vfile);	/* from codename/one */

}	/* fxn */








}	/* BlankController */
