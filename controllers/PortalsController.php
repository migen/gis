<?php

Class PortalsController extends Controller{	

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
	$data=isset($data)? $data:NULL;
	$vfile="portals/indexPortals";
	$this->view->render($data,$vfile);


}	/* fxn */



public function pass($params=NULL){
	$ucid=isset($params[0])? $params[0] : $_SESSION['user']['ucid']; 
	if($_SESSION['srid']!=RMIS){ $ucid=$_SESSION['user']['ucid']; }
	$data['ucid']=$ucid;
	$sy=isset($params[1])?$params[1]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;$db=$this->baseModel->db;
	$url="portals/pass/$ucid";
	
	if(isset($_POST['submit'])){
		$post = $_POST['data'];
		// $ucid    = strtoupper($post['login']);	
		$oldpass  = $post['oldpass'];	
		$newpass  = $post['newpass'];				
		$mdold	  = MD5($oldpass);
		$mdnew	  = MD5($newpass);	
		$q   = " SELECT id,pass FROM {$dbo}.`00_contacts` WHERE id = $ucid LIMIT 1; ";
		$sth = $db->querysoc($q);
		$row = $sth->fetch();
		
		/* check if a) old pass matches, and b) new passes match */
		$oldpassMatched 	= ($row['pass'] === MD5($post['oldpass']))? true:false;
		$newpassesMatched 	= ($post['newpass'] === $post['newpass2'])? true:false;
				
		if($oldpassMatched && $newpassesMatched){									
			$q="UPDATE {$dbo}.`00_contacts` SET `pass` = '$mdnew' WHERE `id` = $ucid LIMIT 1; ";
			$q.="UPDATE {$dbo}.`00_ctp` SET `ctp` = '$newpass' WHERE `contact_id` = $ucid LIMIT 1; ";												
			$db->query($q);
			flashRedirect($url,"Success.");
		} 
		Session::set('message','Passwords do not match.');
		flashRedirect($url,"Passwords do not match.");
		exit;
		
	}	/* post-submit */
	
	if($ucid){
		$q="SELECT ctp.contact_id AS ctpucid,c.id,c.account AS login,c.code FROM {$dbo}.00_contacts AS c 
			LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id WHERE c.id=$ucid LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$data['login']=$row['login'];		
		$data['ctpucid']=$row['ctpucid'];		
		if(!$row['ctpucid']){ 
			$mdpass=MD5('pass');
			$q="UPDATE {$dbo}.00_contacts SET pass='$mdpass' WHERE id=$ucid LIMIT 1; ";
			$db->query($q);
			// 2
			$q="INSERT INTO {$dbo}.00_ctp(contact_id,ctp)VALUES($ucid,'pass'); ";
			$db->query($q);flashRedirect("portals/pass/$ucid","Synced pass."); 
		}
	}
	
	$this->view->render($data,'portals/passPortals');

}	/* fxn */






}	/* BlankController */
