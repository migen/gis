<?php

Class ContactsController extends Controller{	/* GISController from bootstrap */

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	/* $this->view->js = array('js/jquery.js','js/vegas.js');	 */
	$this->view->js = array('js/jquery.js');	 
	parent::beforeFilter();			
	$acl = array(array(5,0),array(6,0),array(9,0),array(7,0));
	$this->permit($acl,$strict=false);					
}	/* fxn */




public function statuses($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/students.php");
	$db	=&	$this->model->db;
	$this->view->js = array('js/jquery.js','js/vegas.js');	

	$data['home']	= $home = $_SESSION['home'];
	$ucid = isset($params[0])? $params[0]:NULL;
	$data['ucid']	= $ucid;

	$allowed = array(RMIS,RREG); 
	$srid 	 = $_SESSION['user']['role_id']; 	
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); } 	
	
	$sesu  = $_SESSION['user'];
	$data['today']		 = $today 	= $_SESSION['today'];
	$data['suid']		 = $suid  	= $_SESSION['suid'];
	$data['srid'] 		 = $srid	= $_SESSION['srid'];
	$data['is_employee'] = $is_employee  	= ($srid==RSTUD)? false:true;

	$data['mis']	= $mis 	= ($srid==RMIS)? true:false;
	$data['reg']	= $reg 	= ($srid==RREG)? true:false;
	$data['guid']	= $guid 	= ($srid==RGUID)? true:false;
			
	$data['ssy']	  = $ssy	= $_SESSION['sy'];	
	$data['sy']		  = $sy	  	= isset($params[1])? $params[1] : $ssy;	
	$dbg	= VCPREFIX.$sy.US.DBG;
			
	if(isset($_POST['update'])){
		$row = $_POST['student'];
		$this->model->db->update("".PDBO.".`00_contacts`",$row,$where=" `id` = '$scid' ");		
		redirect('contacts/statuses/'.$scid);		
	}	/* post */
	
	$data['student'] = (!empty($ucid))? student($db,$dbg,$sy,$ucid):NULL;					
	$this->view->render($data,'registrars/statuses');

}	/* fxn */




public function edit($params=NULL){	/* editContact before */
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	require_once(SITE."functions/selects.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/contactsFxn.php");
	$db=&$this->model->db;
	
	$data['ucid']=$ucid=isset($params[0])? $params[0]:false;	
	$data['ssy']	= $ssy		= $_SESSION['sy'];	
	$data['sy']		= $sy	  	= isset($params[1])? $params[1] : $ssy;	
	$dbg	= VCPREFIX.$sy.US.DBG;
	if(($_SESSION['srid']==1) && ($_SESSION['ucid']!=$ucid)){ redirect('users/logout'); }
	
	/* use model method,use ajax instead */
	if(isset($_POST['editcontact'])){}		/* post-contact */	
	if(isset($_POST['editprofile'])){}		/* post-profile */	
	
	$data['contact'] 		= $contact = $this->model->fetchRow(PDBO.".`00_contacts`",$ucid);
	$data['profile'] 		= $profile = getProfileDetails($db,$ucid,$dbg);
	
	if($contact['role_id']==RSTUD){ $data['student']=student($db,$dbg,$sy,$ucid); }	
	// $data['selects']=selects($this->model);
	
	/* ajax update contacts,manage contact-users,ctp for non-mis,profile,  */
	$this->view->render($data,'contacts/editContact');
}	/* fxn */


 
public function page($params=array(1)){
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	require_once(SITE.'library/Pagination.php');
	$dbg = PDBG;
	$page = isset($_GET['page'])? $_GET['page'] : $params[0];
	if(isset($_GET['page'])) { unset($_GET['page']); }

	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = isset($_POST['rows'])? stringify($_POST['rows']) : null;			
		if(!empty($ids)){
			$url = 'mis/editContacts/'.$ids;
			redirect($url);				
		} 		
	}	/* post */
	$data=$this->model->contacts($page);		/*  */
	$data['num_contacts'] = count($data['contacts']);
	$data['roles']		  = $this->model->fetchRows("".PDBO.".`00_roles`");
	$data['home']		  = $_SESSION['home'];	
	$data = isset($data)? $data : null;				
	$this->view->render($data,'contacts/pageContacts');

}	/* fxn */
 

public function sy($params=NULL){
$dbo=PDBO;
// require_once(SITE."functions/contactsFxn.php");
$db=&$this->model->db;

$data['ucid']	= $ucid = isset($params[0])? $params[0]:$_SESSION['user']['ucid'];

$dbo=PDBO;
$q = " 	SELECT c.id,c.code,c.name,c.sy
		FROM {$dbo}.`00_contacts` AS c
		WHERE c.`id` = '$ucid' LIMIT 1; ";
$sth = $db->querysoc($q);
$data['row'] = $sth->fetch();
$this->view->render($data,'contacts/syContact');


}	/* fxn */

 

public function role($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/contactsFxn.php");
$db =& $this->model->db;

$data['ucid']	= $ucid = isset($params[0])? $params[0]:$_SESSION['user']['ucid'];

$dbo=PDBO;
$q = " 	SELECT c.*,r.name AS role 
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_roles` AS r ON r.id = c.role_id
		WHERE c.`id` = '$ucid' LIMIT 1; ";
$sth = $db->querysoc($q);
$data['contact'] = $sth->fetch();
$data['titles'] = $this->model->fetchRows($dbo.'.`00_titles`');
$this->view->render($data,'contacts/role');


}	/* fxn */


public function staff(){
$dbo=PDBO;
$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if($_SESSION['user']['privilege_id']>0){ flashRedirect($home,'Not admin privilege.'); }
$db=&$this->model->db;$dbg=PDBG;
$q="SELECT c.*,ctp.ctp FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_ctp` ON c.id = ctp.contact_id WHERE c.role_id = '$srid' AND c.privilege_id !=0 ORDER BY c.name; ";
$sth=$db->querysoc($q);
$data['rows'] = $rows = $sth->fetchAll();
$data['count'] = count($rows);

$this->view->render($data,'contacts/staff');


}	/* fxn */

 
public function editContacts($ids){
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/dbFxn.php");
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	$contacts 	= $_POST['contacts'];
	$profiles 	= $_POST['profiles'];
	$q = "";
	$i = 0;
	foreach($contacts AS $row){
		$row['account'] = $row['code'];
		$has_profile  = rowExists($db,"{$dbo}.`00_profiles`",$key="contact_id",$value=$row['id'],"id");

		if($has_profile){ $db->update("{$dbo}.`00_profiles`",$profiles[$i]," `contact_id` = '".$row['id']."' ");	
		} else { $profile['contact_id'] = $row['id']; $db->add("{$dbo}.`00_profiles`",$profiles[$i]); }

		$db->update("{$dbo}.`00_contacts`",$row," `id` = '".$row['id']."' ");			
		$i++;
	}
	// pr($q); exit;
	$this->model->db->query($q);
	$params = implode("/",$ids);
	$url = "mis/editContacts/$params";
	// pr($url);
	redirect($url);
	exit;
	
}	/* post-submit */


foreach($ids as $id){ $data['contacts'][] = readContact($db,$id); }			
$data['num_contacts']	= count($data['contacts']);
$data['departments']	= $this->model->fetchRows("".PDBO.".`05_departments`");
$data['titles']			= $this->model->fetchRows(DBO.".`00_titles`");


$this->view->render($data,'contacts/editContacts');

} 	/* fxn */


public function dept($params){
$dbo=PDBO;
$ecid = $params[0];
$dbg=PDBG;$db=&$this->model->db;

if(isset($_POST['submit'])){
	$this->syncCdept($ecid);
	$ps = isset($_POST['ps'])? '1' : '0';
	$gs = isset($_POST['gs'])? '1' : '0';
	$hs = isset($_POST['hs'])? '1' : '0';	
	$q = " UPDATE {$dbo}.`88_contacts_departments` SET 
		`is_ps` = '$ps', `is_gs` = '$gs', `is_hs` = '$hs'  
		WHERE `contact_id` = '$ecid' LIMIT 1;";
	$this->model->db->query($q);	
	$url = 'mis/multiusers';
	redirect($url);	
	exit;

}	/* post */

$q = "
	SELECT 
		c.*,cd.*
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`88_contacts_departments` AS cd ON cd.contact_id = c.id
	WHERE c.`id` = '$ecid' LIMIT 1;	
";
$sth = $this->model->db->querysoc($q);
$data['contact'] = $contact = $sth->fetch();
$role_id = $contact['role_id'];
if($role_id==1){ Session::set('message','Students Not Allowed'); redirect(); }

$this->view->render($data,'contacts/dept');


}	/* fxn */



public function one($params=NULL){
$dbo=PDBO;
$this->view->js = array('js/jquery.js','js/vegas.js');	
$ucid=isset($params[0])? $params[0]:false;
$data['ucid']=&$ucid;

$this->view->render($data,'contacts/oneContact');

}	/* fxn */


public function makol($params=NULL){
$dbo=PDBO;
$this->view->js = array('js/jquery.js','js/vegas.js');	
$ucid=isset($params[0])? $params[0]:false;
$data['ucid']=&$ucid;

$this->view->render($data,'contacts/getMakol');

}	/* fxn */


public function csy($params=NULL){
	require_once(SITE."functions/logs.php");
	$dbo=PDBO;
	$scid=$params[0];
	$db=&$this->model->db;$dbo=PDBO;
	if(isset($_POST['submit'])){
		$csy=$_POST['csy'];
		$q="UPDATE {$dbo}.`00_contacts` SET `sy`='$csy' WHERE `id`='$scid' LIMIT 1; ";
		$db->query($q);
		$axn = $_SESSION['axn']['editcsy'];
		$more['ecid'] = $_SESSION['ucid'];				
		logThis($db,$scid,$axn,NULL,$more);		
		flashRedirect("contacts/csy/$scid","Contacts SY edited.");
	}
	$q="SELECT `id` AS scid,`sy`,`name` AS student FROM {$dbo}.`00_contacts` WHERE `id`='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$this->view->render($data,'contacts/csyContacts');
	

}	/* fxn */


public function index(){
	$data="Contacts";
	$this->view->render($data,"contacts/indexContacts");
	
}



public function ucis($params=NULL){
$dbo=PDBO;$db=&$this->baseModel->db;
$data['ucid']=$ucid=isset($params[0])? $params[0]:false;
	


if(isset($_POST['submit'])){
	$index=strtolower($_POST['submit']);$post=$_POST[$index];$tbl="{$dbo}.`00_{$index}s`";
	$id=$post['id'];unset($post['id']); 
	$db->update("{$tbl}",$post,"id=$id");
	flashRedirect("contacts/ucis/$ucid","Updated");	
	exit;
}	/* post */
/* $q="SELECT count(*) AS numcols FROM information_schema.columns WHERE TABLE_SCHEMA='{$dbo}' AND TABLE_NAME='00_contacts'; "; */
// unset($_SESSION['cols']);
sessionizeColumnsOfDbtable($db,$dbo,"00_contacts","contacts",$except="'null'");
sessionizeColumnsOfDbtable($db,$dbo,"00_profiles","profiles",$except="'null'");

$data['contacts_cols']=$_SESSION['cols']['contacts'];
$data['contacts_count']=$_SESSION['cols']['contacts_count'];

$data['profiles_cols']=$_SESSION['cols']['profiles'];
$data['profiles_count']=$_SESSION['cols']['profiles_count'];



if($ucid){
	$data['contact']=fetchRecord($db,"{$dbo}.`00_contacts`","id=$ucid");
	$data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$ucid");
	

}	/* ucid */



$data['text_array']=array('address','remarks');

$vfile="contacts/ucisContact";

// pr($data);exit;
$this->view->render($data,$vfile);

}	/* fxn */



public function addByRole(){
	
	
	$this->view->render($data,"contacts/addByRoleContacts");
}	/* fxn */



	
}	/* ContactsController */
