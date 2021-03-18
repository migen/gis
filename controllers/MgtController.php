<?php
Class MgtController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */


public function index($params=NULL){
	pr("Mgt");
}	/* fxn */


public function ajax(){	$this->view->render(NULL,"mis/ajaxMis"); }	/* fxn */

public function ajaxProcess(){
	$dbo=PDBO;$db=&$this->baseModel->db;$dbtable=$_POST['dbtable'];
	$q="SELECT  max(id) AS `numrows` FROM $dbtable ;";
	$sth=$db->querysoc($q); // $_SESSION['q'] = $q;
	$row=$sth->fetch();
	echo json_encode($row);
}	/* fxn */



public function users($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/users.php");
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/registration.php");


$data['ssy']=$ssy=DBYR;
$data['ucid']	  = $ucid 	 = $params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db =& $this->baseModel->db;$dbg= VCPREFIX.$sy.US.DBG; 
$uc	= $this->baseModel->fetchRow(PDBO.'.`00_contacts`',$ucid);
$data['pcid']	  = $pcid 	 = $uc['parent_id'];
$data['current']  = $current = ($sy==DBYR)? true:false;

$_SESSION['users']['pcid'] = $pcid;

if(isset($_POST['pcdept'])){
	$pcid = $_POST['parent']['cid'];
	syncCdept($db,$pcid,$dbg);

	$ps = isset($_POST['parent']['ps'])? '1' : '0';
	$gs = isset($_POST['parent']['gs'])? '1' : '0';
	$hs = isset($_POST['parent']['hs'])? '1' : '0';
	
	$q = " UPDATE {$dbo}.`88_contacts_departments` SET 
		`is_ps` = '$ps',`is_gs` = '$gs',`is_hs` = '$hs'  
		WHERE `contact_id` = '$pcid' LIMIT 1; ";
	$this->baseModel->db->query($q);	
	$url = 'mgt/users/'.$pcid;
	redirect($url);	
	exit;

}	/* post */


if(isset($_POST['submit'])){	
	$pcid = $_POST['pcid'];
	$code = $_POST['code'];
	$active = $_POST['active'];
	$clear  = $_POST['clear'];
	$year	= date('Y');
	
	$rows = $_POST['users'];
	$mdpass = MD5('pass');
	$ucid = lastContactId($db,$dbg);
	
	$q = "";
	foreach($rows AS $row){	
		$code = $row['login'];
		$exists = validateCode($db,$code,$dbg);
		if(!$exists){	
			$ucid++;
			/* 1-contacts */
			$q .= " INSERT IGNORE INTO {$dbo}.`00_contacts` (
				`id`,`name`,`parent_id`,`code`,`account`,`is_active`,`is_cleared`,
				`title_id`,`role_id`,`privilege_id`,`pass`,`sy`) VALUES (			
				'$ucid','".$_SESSION['user']['fullname']."','$pcid','".$row['login']."','".$row['login']."','$active','$clear',
				'".$row['title']."','".$row['role']."','".$row['priv']."',
				'".$mdpass."','$year'); ";
							
			/* 2-ctp,photos; NO profiles,attendance, photos */	
			$q .= " INSERT IGNORE INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`,`ctpb`) VALUES ('$ucid','pass','pass'); ";			
			
		} /* exists */
	}
	// pr($q);exit;
	$this->baseModel->db->query($q);									
		
	/* 3-redirect */
	$url = "mgt/users/$pcid/$sy";
	redirect($url);
	exit;	

}	/* post-submit */


$data['parent'] = getParentDetails($db,$pcid,$dbg);
$data['pcid']	= $pcid;
$data['users']  = getUsers($db,$pcid,$dbg);
$data['num_users']   = count($data['users']);
$data['titles'] 	 = $this->baseModel->fetchRows("".PDBO.".`00_titles`");
$data['departments'] = $this->baseModel->fetchRows("".PDBO.".`05_departments`");	

$data['lastnum'] 		= lastContactNumber($db,$sy);
$data['laststud'] 		= lastContact($db,$sy,$stud=1);
$data['lastempl'] 		= lastContact($db,$sy,$stud=0);
$data['prefix']			= $_SESSION['settings']['code_prefix'];
$data['delimeter']		= $_SESSION['settings']['code_delimeter'];


$this->view->render($data,'mis/users');


}	/* fxn */


public function contacts($params=NULL){
	
$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
$data['home']=$_SESSION['home'];

if(isset($_GET['filter'])){
	$params = $_GET;	
	$sort=$params['sort'];$order=$params['order'];
	$page=$params['page'];$limits=$params['limits'];$offset=($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['lvl'])){ $cond .= " AND cr.level_id = '".$params['lvl']."'"; }				
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }				
	if (!empty($params['role_id'])){ $cond .= " AND c.role_id = '".$params['role_id']."'"; }				
	if (isset($params['priv'])){ $cond .= " AND c.privilege_id = '".$params['priv']."'"; }				
	if (!empty($params['code'])){ $cond .= " AND (c.code LIKE '%".$params['code']."%'
		OR c.`account` LIKE '%".$params['code']."%')"; }				
	if (!empty($params['name'])){ $cond .= " AND c.name LIKE '%".$params['name']."%'"; }	
	if (!empty($params['sy'])){ $cond .= " AND c.`sy` = '".$params['sy']."'"; }	

	$q=" SELECT c.*,ctp.ctp 
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE 1=1 $cond ORDER BY $sort $order $condlimits; ";
	$data['q']=$q;	
	debug($q);
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
} else {
	$data['roles'] = $_SESSION['roles'];
	$data['levels'] = $_SESSION['levels'];
	$data['classrooms'] = $_SESSION['classrooms'];
}

if(isset($_POST['update'])){
	$q = "";
	$posts = $_POST['posts'];
	foreach($posts AS $post){
		$q.="UPDATE {$dbo}.`00_contacts` SET `parent_id` = '".$post['parent_id']."',
			`code` = '".$post['code']."',`account` = '".$post['account']."',
			`pass` = '".MD5($post['ctp'])."',`name` = '".$post['name']."',
			`title_id` = '".$post['title_id']."',`role_id` = '".$post['role_id']."',
			`privilege_id` = '".$post['privilege_id']."',
			`is_male` = '".$post['is_male']."',`is_active` = '".$post['is_active']."',
			`is_cleared` = '".$post['is_cleared']."',`sy` = '".$post['sy']."'
		WHERE `id` = '".$post['ucid']."' LIMIT 1; ";
		
		$q.="UPDATE {$dbo}.`00_ctp` SET `ctp` = '".$post['ctp']."' WHERE `contact_id` = '".$post['ucid']."' LIMIT 1;  ";
	}
	$db->query($q);
	$url = "mgt/contacts";
	flashRedirect($url,'Contacts updated.');
	exit;

}	/* update */

$data['sort'] = $sort = isset($sort)? $sort : 'p.name';
$data['order'] = $order = isset($order)? $order : 'ASC';
$data['page'] = $page = isset($page)? $page : '1';
$data['limits'] = $limits = isset($limits)? $limits : '20';
$data['sy']=isset($params[0])? $params[0]:DBYR;

$vfile='mis/contactsMis';vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */

public function today(){ echo "Session: "; print($_SESSION['today']);  echo "<br>Date: "; print(date('Y-m-d')); }


public function pass($params=NULL){

$data['id']	= $id = isset($params[0])? $params[0]:false;
$db=&$this->baseModel->db;
$dbg=PDBG;$dbo=PDBO;

if($id){
	$q = " SELECT c.*,ctp.*
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		WHERE c.id = '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$data['contact'] = $contact = $sth->fetch();
	$pcid=$contact['parent_id'];
	/* 1 only sudo can view superuser account */
	$ucid=$_SESSION['ucid'];$srid=$_SESSION['srid'];
	if(($pcid==1) && !sudo()){ }
	
}	/* id */
	
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
		$url="mgt/pass/$id";
		flashRedirect($url,"User password changed.");
	} 
}	/* post */
/* ----------------- process ------------------------- */
if(empty($contact['ctp'])){
	$q="INSERT INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`)VALUES('$id','pass'); ";
	$db->query($q);
}

$this->view->render($data,'mis/passMis');

}	/* fxn */



public function cls(){
	session_destroy();clearstatcache();
}	/* fxn */





 
} 	/* MisController */

