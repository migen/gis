<?php

Class AxisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
	
}


public function index(){ 
	$data['home']=$_SESSION['home'];
	$this->view->render($data,'axis/indexAxis');
	

}	/* fxn */


public function add(){ 
	$data = null;
	$this->acl();
	$this->view->render($data,'axis/index');
	

}	/* fxn */


public function reset($params){
	$dbo=PDBO;
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->model->db;

	$ctlr 	= $params[0];
	$dbg	= PDBG;
		
	sessionizeSupplier($db,$dbg);
	$_SESSION['home']	= $_SESSION['user']['home'];
	redirect($ctlr);
} 	/* fxn */


public function batchFees(){	/* setupAddons */
require_once(SITE."functions/setup.php");
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","id,is_discount,name,amount","name");
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id");
$data['today'] = $today = $_SESSION['today'];

if(isset($_POST['submit'])){

$scids=array();
if(isset($_POST['students'])){
	$scids=$_POST['students'];
} elseif($_POST['fee']['classroom']>0) {
	$crid=$_POST['fee']['classroom'];
	$aw=" WHERE crid='$crid'";
	$a=fetchRows($db,"{$dbo}.`00_contacts`","id","name",$aw);
	$scids = buildArray($a,'id');
} elseif($_POST['fee']['level']>0) {
	$g['level']=$_POST['fee']['level'];
	$b=getCurrentStudents($db,$g);
	$scids = buildArray($b,'scid');	
} 

$feeid=($_POST['fee']['feetype_id']>0)? $_POST['fee']['feetype_id']:false;
$amount=$_POST['fee']['amount'];
$num=$_POST['fee']['num'];
$due=$_SESSION['today'];
$due=isset($_POST['fee']['due'])? $_POST['fee']['due']:$today; 
// $withdue=isset($_POST['fee']['withdue'])? $_POST['fee']['withdue']:false; 
if((!empty($scids)) && ($feeid)){
	$ecid=$_SESSION['ucid'];
	
	$q=" INSERT IGNORE INTO {$dbg}.`30_auxes`(`ecid`,`scid`,`feetype_id`,`amount`,`num`,`due`) VALUES ";
	foreach($scids AS $scid){
		$q.="('$ecid','$scid','$feeid','$amount','$num','$due'),";
	}	
	$q=rtrim($q,",");
	$q.=";";
}
// pr($q); exit;
$db->query($q);
$url="axis/batchFees";
flashRedirect($url,'Batch Fees added.');
exit;

}	/* post */

$data['get'] = $get = isset($_GET)? $_GET:false;
$data['students'] = $students = (isset($get['level']) || isset($get['classroom']))? getCurrentStudents($db,$get):NULL;
$data['count'] = count($students);

// pr($data);

$this->view->render($data,'axis/batchFees');

}	/* fxn */


public function reloading($params=NULL){
$dbo=PDBO;

require_once(SITE."functions/terminals.php");
$db =& $this->model->db;

$data['home']	= $home		= $_SESSION['home'];
$data['user']	= $user	  	= $_SESSION['user'];
$data['scid']	= $scid  	= $user['ucid'];
$data['srid']	= $srid  	= $user['role_id'];

$data['ucid']	= $ucid		= isset($params[0])? $params[0] : $scid;

$acl = array(array(5,0),array(2,0));
$this->permit($acl);				

// $data['ip'] 		= $ip 		= $_SERVER['REMOTE_ADDR'];	/* live */
$data['ip'] 		= $ip 		= getHostByName(getHostName());	/* local devt */
$data['terminal']	= $terminal = getTerminal($db,$ip);

if(isset($_POST['submit'])){
	$row = $_POST['balance'];
	$row['balance'] += $_POST['amount'];
	$row['date'] = date('Y-m-d');
	$row['time'] = date('H:i:s');
	
	$this->baseModel->db->update(DBO.".`balances`",$row," `contact_id` = '".$ucid."' ");
	// pr($row); exit;
	clearTerminal($db,$terminal);
	$url = "accounts/reloading/$ucid";
	redirect($url);
	exit;	
}	/* post */

/* ------------ process ---------------------- */

$data['balance'] = $this->baseModel->getBalance($ucid);
if(!isset($data['balance']['contact_id'])){
	$this->baseModel->syncBalance($ucid);
	redirect("$home/reloading/$ucid");
} 



$this->view->render($data,'accounts/reloading');

} 	/* fxn */


public function batchRemarks(){	/* setup Remarks */
require_once(SITE."functions/setup.php");
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id");
$data['today'] = $today = $_SESSION['today'];

if(isset($_POST['submit'])){

$scids=array();
if(isset($_POST['students'])){
	$scids=$_POST['students'];
} elseif($_POST['post']['classroom']>0) {
	$crid=$_POST['post']['classroom'];
	$aw=" WHERE crid='$crid'";
	$a=fetchRows($db,"{$dbo}.`00_contacts`","id","name",$aw);
	$scids = buildArray($a,'id');
} elseif($_POST['post']['level']>0) {
	$g['level']=$_POST['post']['level'];
	$b=getCurrentStudents($db,$g);
	$scids = buildArray($b,'scid');	
} 

$remarks=$_POST['post']['remarks'];
$remarks=str_replace("'","\\'",$remarks);
if((!empty($scids))){
	$q="";
	foreach($scids AS $scid){
		$q.=" UPDATE {$dbg}.03_tsummaries SET `remarks`='$remarks' WHERE `scid`='$scid' LIMIT 1; ";
	}		
}
// pr($q); exit;
$db->query($q);
$url="axis/batchRemarks";
flashRedirect($url,'Batch Remarks added.');
exit;

}	/* post */

$data['get'] = $get = isset($_GET)? $_GET:false;
$data['students'] = $students = (isset($get['level']) || isset($get['classroom']))? getCurrentStudents($db,$get):NULL;
$data['count'] = count($students);


$this->view->render($data,'axis/batchRemarks');

}	/* fxn */



public function purgeEmptyAuxes($params=NULL){
$home=$_SESSION['home'];
$db=&$this->model->db;
$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;
$q="DELETE FROM {$dbg}.`30_auxes` WHERE amount < 1; ";
$sth=$db->query($q);
$msg=($sth)? "Auxes Delete Success":"Auxes Delete Failed";
flashRedirect($home,$msg);

}	 /* fxn */


// ---------------- 2020 below ----------------

// public 








}	/* AxisController */
