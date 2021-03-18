<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class ExtraController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	/* $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 */
	
}


public function beforeFilter(){}
public function index(){}



public function securePassword($params){
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



public function securePasswordStudent($params){
	isset($params[0])? $data['login'] = $params[0] : redirect('students/login');
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])?$params[1]:$ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$post = $_POST['data'];
		$login    = strtoupper($post['login']);	
		$oldpass  = $post['oldpass'];	
		$newpass  = $post['newpass'];				
		$mdold	  = MD5($oldpass);
		$mdnew	  = MD5($newpass);
		
		$q = " SELECT id,passb FROM {$dbo}.`00_contacts` WHERE `account` = '$login' AND `passb` = '$mdold' LIMIT 1; ";
		$sth = $this->Extra->db->querysoc($q);
		$row = $sth->fetch();
		$cid = $row['id'];
		
		/* check if a) old pass matches, and b) new passes match */
		$oldpassMatched 	= ($row['passb'] === MD5($post['oldpass']))? true:false;
		$newpassesMatched 	= ($post['newpass'] === $post['newpass2'])? true:false;
				
		if($oldpassMatched && $newpassesMatched){												
			$q  = " UPDATE {$dbo}.`00_contacts` SET `passb` = '$mdnew' WHERE `id` = '$cid' LIMIT 1; ";
			$q .= " UPDATE {$dbo}.`00_ctp` SET `ctpb` = '$newpass' WHERE `contact_id` = '$cid' LIMIT 1; ";									
			$this->Extra->db->query($q);										
			redirect('users/logout');				
		} 
		Session::set('message','Passwords do not match.');
		
	}	/* post-submit */
	
	$this->view->render($data,'extra/securePassword');

}	/* fxn */











} /* ExtraController */
