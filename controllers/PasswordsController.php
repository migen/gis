<?php

Class PasswordsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	

}	/* fxn */



public function securePassword($params){
$dbo=PDBO;
	isset($params[0])? $data['login'] = $params[0] : redirect('users/login');
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])?$params[1]:$ssy;

	$dbg	= VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$post = $_POST['data'];
		// pr($_POST);exit;
		$login    = strtoupper($post['login']);	
		$oldpass  = $post['oldpass'];	
		$newpass  = $post['newpass'];				
		$mdold	  = MD5($oldpass);
		$mdnew	  = MD5($newpass);
				
		$q   = " SELECT id,pass FROM {$dbo}.`00_contacts` WHERE account = '$login' AND pass = '$mdold' LIMIT 1; ";
		$sth = $this->Extra->db->querysoc($q);
		$row = $sth->fetch();
		$cid = $row['id'];
		
		/* check if a) old pass matches, and b) new passes match */
		$oldpassMatched 	= ($row['pass'] === MD5($post['oldpass']))? true:false;
		$newpassesMatched 	= ($post['newpass'] === $post['newpass2'])? true:false;
		
		if($oldpassMatched && $newpassesMatched){									
			$q  = " UPDATE {$dbo}.`00_contacts` SET `pass` = '$mdnew' WHERE `id` = '$cid' LIMIT 1; ";
			$q .= " UPDATE {$dbo}.`00_ctp` SET `ctp` = '$newpass' WHERE `contact_id` = '$cid' LIMIT 1; ";												
			$this->Extra->db->query($q);										
			redirect('users/logout');				
		} 
		Session::set('message','Passwords do not match.');
		$url="extra/securePassword";
		flashRedirect($url,"Passwords do not match.");
		// pr($url);
		exit;
		
	}	/* post-submit */
	
	
	$this->view->render($data,'extra/securePassword');

}	/* fxn */




public function account($params=NULL){
	if($_SESSION['srid']==RMIS){ $ucid=$params[0];
	} else { $ucid=$_SESSION['user']['ucid']; }
	$dbo=PDBO;$db=&$this->model->db;
	$data['ucid']=&$ucid;	
	if(isset($_POST['submit'])){
		$q="UPDATE {$dbo}.`00_contacts` SET `name`='".$_POST['name']."',`account`='".$_POST['account']."'
			WHERE id='$ucid' LIMIT 1; ";
		$db->querysoc($q);
		flashRedirect("index","Username changed.");
		exit;
	}	
	$data['row']=fetchRow($db,"{$dbo}.`00_contacts`",$ucid);		
	$this->view->render($data,'passwords/account');

}	/* fxn */



public function one($params=NULL){
$data['id']	= $id = isset($params[0])? $params[0]:false;
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

/* 1 only sudo can view superuser account */
$ucid=$_SESSION['ucid'];$srid=$_SESSION['srid'];
// pr($_SESSION['user']['privilege_id']);
if($_SESSION['user']['privilege_id']>0){ flashRedirect(); }

if(($id==1) && !sudo()){ }

if(isset($_POST['submit'])){
	$post = $_POST['data'];
	if($post['newpass'] === $post['newpass2']){
		$newpass  = $post['newpass'];				
		$mdnew	  = MD5($newpass);				
		$q  = " UPDATE {$dbo}.`00_contacts` SET 
			`pass` = '$mdnew',`account` = '".$post['account']."',`code` = '".$post['code']."', 
			`title_id` = '".$post['title_id']."',`role_id` = '".$post['role_id']."',
			`privilege_id` = '".$post['privilege_id']."' WHERE `id` = '$id' LIMIT 1; ";
		$sth=$db->prepare($q);
		$sth->execute([$mdnew,$id]);    		
				
		$q = " UPDATE {$dbo}.`00_ctp` SET `ctp` = '$newpass' WHERE `contact_id` = '$id' LIMIT 1; ";
		$sth=$db->prepare($q);
		$sth->execute([$newpass,$id]);    				
		$url="passwords/one/$id";
		flashRedirect($url,"User password changed.");
	} 

}	/* post */

/* ----------------- process ------------------------- */
$q = " SELECT c.*,ctp.*
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
	WHERE c.id = '$id' LIMIT 1;		
";

$sth = $this->model->db->querysoc($q);
$data['contact'] = $contact = $sth->fetch();
if(empty($contact['ctp'])){
	$q="INSERT INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`)VALUES('$id','pass'); ";
	$db->query($q);
}

$this->view->render($data,'passwords/onePasswords');

}	/* fxn */


public function teachers(){
require_once(SITE.'functions/passwordsFxn.php');
$home=$_SESSION['home'];$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
$srid=$_SESSION['srid'];
$ar=array(RTEAC,RMIS,RREG,RADMIN);
if(!in_array($srid,$ar)){ flashRedirect(); }
if(($srid==RTEAC) && ($_SESSION['user']['privilege_id']!=0)) { flashRedirect(); }
$data['rows']=getPasswordsByRole($db,$dbo,RTEAC);
$data['count']=count($data['rows']);

$this->view->render($data,'passwords/teachersPasswords');

}	/* fxn */



public function resets($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['ucid']=$ucid=isset($params[0])? $params[0]:false;	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$acl=array(array(5,0),array(2,0),array(4,0),array(9,0));$this->permit($acl);				
	
	if(isset($_POST['submit'])){
		$post=$_POST;
		$ucid=$post['ucid'];$rawpass=$post['pass'];$mdpass=MD5($post['pass']);		
		$subject_name=$post['subject_name'];
		$q="UPDATE {$dbo}.00_contacts SET pass='$mdpass' WHERE id=$ucid LIMIT 1; ";
		$q.="UPDATE {$dbo}.00_ctp SET ctp='$rawpass' WHERE contact_id=$ucid LIMIT 1; ";
		$sth=$db->query($q);
		$message=($sth)? "Success":"Fail";		
		/* ezlog */
		$ip=$_SERVER['REMOTE_ADDR'];$ts=date("Y-m-d H:i:s");$today=$_SESSION['today'];$user_id=$_SESSION['ucid'];
		$username=$_SESSION['user']['fullname'];
		$details="$username reset password $subject_name to $rawpass.";					
		$q="INSERT INTO {$dbg}.50_logs(`ip`,`datetime`,`ucid`,`details`)VALUES('$ip','$ts',$user_id,'$details');";
		$sth=$db->prepare($q);
		$sth->execute(); 
		pr($sth->errorInfo());		
		$message=($sth)? "Success":"Fail";
		flashRedirect("passwords/resets/$ucid",$message);
		exit;		
	}	/* fxn */
	
	
	if($ucid){
		$q="SELECT c.id AS ucid,c.role_id,c.account,c.code,c.name,p.birthdate,ctp.id AS ctpid,ctp.ctp 
			FROM {$dbo}.00_contacts AS c LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id 
			LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id WHERE c.id=$ucid LIMIT 1;";
		debug($q);
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		if(!isset($row['ctpid'])){ $q="INSERT INTO {$dbo}.00_ctp(contact_id)VALUES($ucid);";$db->query($q); }
		$subject_is_student=($row['role_id']==RSTUD)? true:false;
		$data['subject_is_student']=&$subject_is_student;
		$data['row']=$row;				
		$data['has_subject']=true;		

		// 2
		if(($row['role_id']!=RSTUD) && $_SESSION['srid']!=RMIS){
			$msg='Not allowed.';
			flashRedirect('passwords/resets',$msg);
		}
		
	}	else {
		$data['has_subject']=false;
		
	}
	
	
	$view="passwords/resetsPassword";	
	$this->view->render($data,$view);
	
}	/* fxn */





}	/* BlankController */
