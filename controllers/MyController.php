<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class MyController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	/* $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 */
	
}


public function beforeFilter(){}


public function index(){
$dbo=PDBO;
	$data['user']	= $user		= $_SESSION['user'];
	$data['ucid']	= $user['ucid'];
	$data['sy']		= $_SESSION['sy'];
	$data['moid']	= $_SESSION['moid'];
	$data['today']	= $_SESSION['today'];
	// $data['empl']	= $_SESSION['is_employee'];

	$this->view->render($data,'my/myIndex');
}	/* fxn */





public function accounts($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/sessionize.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
	$pcid = $_SESSION['user']['parent_id'];
	if(isset($params[0]) && $_SESSION['srid']==RMIS){ $pcid = $params[0]; }
	$data['pcid'] = $pcid;		
	if($pcid==1 && !sudo()){}	
	$data['rows'] = $_SESSION['user_roles'];
	$data['count'] = $_SESSION['num_user_roles'];
	$this->view->render($data,'my/myAccounts');

}	/* fxn */


public function switcher($params){
$dbo=PDBO;
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_role.php");
	$loggedin = loggedin();
	if(!$loggedin) redirect('users/login');
	$data['ucid']=$ucid=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$contact=fetchRow($db,"{$dbo}.`00_contacts`",$ucid);
	if($_SESSION['pcid']!=$contact['parent_id']) $this->flashRedirect();	
	resessionizeUser($db,$ucid);			// 1 - sessionize user
	$role=$_SESSION['home'];		
	$fxn="sessionize_$role";$fxn($db);	// 2 - sessionize role			
	redirect($role);

}	/* fxn */



public function uf($params){	// updateFullname
$dbo=PDBO;
	$pcid=$params[0];
	$dbo=PDBO;$db=&$this->baseModel->db;
	$q="SELECT name FROM {$dbo}.`00_contacts` WHERE id='$pcid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$fullname=$row['name'];
	$q="UPDATE {$dbo}.`00_contacts` SET name='$fullname' WHERE `parent_id`='$pcid';  ";	
	$db->query($q);
	$home=$_SESSION['home'];
	flashRedirect($home,'Fullname updated.');

}	/* fxn */






} /* MyController */
