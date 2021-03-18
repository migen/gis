<?php

Class CodenameController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
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








}	/* BlankController */
