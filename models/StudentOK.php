<?php

class Student extends Model{


public function __construct(){
	parent::__construct();
}

/* for student not parent */
public function authenticate($dbg=PDBG){
	$dbo=PDBO;	
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->db;

	/* 1 - login */
	$code = trim($_POST['data']['User']['code']);
	$pass = trim($_POST['data']['User']['pass']);
	$validated = $this->validateLogin($code,$pass);
	if(!$validated){
		Session::message('Bad login!');
		unset($_POST['data']['User']);
		return false;
	}			
	$pass = MD5($pass);				
		
	$q  = " 
			SELECT 
				c.id AS ucid,c.parent_id AS contact_id,c.parent_id AS pcid,c.code,c.account AS username,
				c.title_id,c.role_id,c.privilege_id,
				pc.name AS fullname,
				t.code AS title_code,t.name AS title
			 FROM {$dbo}.`00_contacts` AS c 
				LEFT JOIN {$dbo}.`00_contacts` AS pc ON pc.id = c.parent_id
				LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id 
			 WHERE ( c.`account` = '$code' AND c.`passb` = '$pass' AND c.is_active = 1 ) 
			LIMIT 1; 
	 ";						
	$sth 	= $this->db->querysoc($q);
	$user 	= $sth->fetch();
	
	// pr($q); exit;
	if($user){	
		$_SESSION['home']		= getRoleById($user['role_id']);	
		$_SESSION['user']		= $user;
		$_SESSION['loggedin'] 	= true;		
		$_SESSION['user']['child']	= 1;
		
		/* sessionizeStudent */
		$this->reset(); 		
		return true;
	} 
	
	return false;
	
}	/* fxn */

function validateLogin($username,$password){	
	if(!preg_match('/^[a-z\d_+=!@\-?$#*%]{3,20}$/i',$username)) {return false; }
	if(!preg_match('/^[a-z\d_+=!@\-?$#*%]{3,20}$/i',$password)) {return false; }
	return true;
}


public function reset($dbg=PDBG){
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->db;

	$ucid = $_SESSION['user']['ucid'];	
	/* 2 - settings */	
	sessionizeSettingsGis($db,$dbg);	
	sessionizeUserByUcid($db,$ucid);	
	sessionizeTime();
		
	
}	/* fxn */
 





} /* Student */


