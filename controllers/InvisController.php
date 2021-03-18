<?php

Class InvisController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}


public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$acl = array(array(RMIS,0),array(RINVIS,0));
	$this->permit($acl);				
	
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;	
	require_once(SITE."functions/pos.php");
	$db=&$this->model->db;
	$dbg=PDBG;

	$trml = myTerminal($db);
	$data['ssy'] = $ssy	= $_SESSION['sy'];
	$data['sy']	= $sy = $ssy;
				
	$this->view->render($data,'invis/indexInvis');

}	/* fxn */



public function reset($params=NULL){
	$dbo=PDBO;	
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_invis.php");
	$db	=&	$this->model->db;		
	sessionizeInvis($db);	
	redirect($_SESSION['home']);
} 	/* fxn */



public function totalInventoryLevel(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$tmax=(isset($_GET['tmax']))? $_GET['tmax']:$_SESSION['settings']['numterminals'];
$expr="level=(";
for($i=1;$i<=$tmax;$i++){ $expr.="t{$i}+"; }
$expr=rtrim($expr,"+");
$expr.=")";

$q=" UPDATE {$dbo}.`03_products` SET $expr ;";
$sth=$db->query($q);
$msg = ($sth)? "Tallied Inventory Level Done":"Not processed.<br />$q"; 
$url=$_SESSION['home']; 
flashRedirect($url,$msg);
 
} 	/* fxn */






public function mit1(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;

$srid=$_SESSION['srid'];
$admin=(($srid==RINVIS) && ($_SESSION['user']['privilege_id']==0) || ($srid==RMIS))? true:false;
$editable=($admin || ($_SESSION['settings']['staffinvis_setup']==1))? true:false;
$data['editable']=$editable;

require_once(SITE."functions/pos.php");
require_once(SITE."functions/inventory.php");
$trml = myTerminal($db);
$trml=isset($_GET['terminal'])? $_GET['terminal']:$trml;
$data['t'] = $t = $trml;
$params=$_GET;
if(isset($_GET['sold'])){
	$data['rows']=getSoldProducts($db,$t);
} else {
	$cond="";
	if (!empty($params['suppid'])){ 
		$cond .= " AND pr.suppid = '".$params['suppid']."' "; 
		$data['t'] = $t = (!empty($params['terminal']))? $params['terminal']:1;		
		$data['rows']=getProducts($db,$cond);			
	} 

}
$data['count']=isset($data['rows'])? count($data['rows']):0;
$data['terminals']=fetchRows($db,"{$dbo}.terminals","*","id");
$where="WHERE role_id='".RSUPP."'";
$data['suppliers']=fetchRows($db,"{$dbo}.`00_contacts`","id,name","name",$where);
$this->view->render($data,'invis/mit1');

}	/* fxn */




public function mit(){
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;

$srid=$_SESSION['srid'];
$admin=(($srid==RINVIS) && ($_SESSION['user']['privilege_id']==0) || ($srid==RMIS))? true:false;
$editable=($admin || ($_SESSION['settings']['staffinvis_setup']==1))? true:false;
$data['editable']=$editable;

if(isset($_POST['submit'])){
	$url=$_SERVER['REDIRECT_QUERY_STRING'];
	$url=ltrim($url,"url=");	
	$posts=$_POST['posts'];$q="";
	foreach($posts AS $post){
		$q.="UPDATE {$dbg}.03_products SET `cost`='".$post['cost']."',`price`='".$post['price']."' 
			WHERE `id`='".$post['prid']."' LIMIT 1; ";
	}
	// pr($q);exit;
	$sth=$db->query($q);
	$msg=($sth)? "Success":"Fail";
	flashRedirect($url,$msg);	
	exit;	
	
	
}	/* post */

require_once(SITE."functions/pos.php");
require_once(SITE."functions/inventory.php");
require_once(SITE."functions/serverFxn.php");
$trml = myTerminal($db);
$trml=isset($_GET['terminal'])? $_GET['terminal']:$trml;
$data['t'] = $t = $trml;
$params=$_GET;
if(isset($_GET['sold'])){
	$data['rows']=getSoldProducts($db,$t);
} else {
	$cond="";
	if (!empty($params['suppid'])){ 
		$cond .= " AND pr.suppid = '".$params['suppid']."' "; 
		$data['t'] = $t = (!empty($params['terminal']))? $params['terminal']:1;		
		$dr=getProductsBySupplier($db,$t,$cond,$sort="pr.name",$order="ASC");			
		$data['rows']=$dr['rows'];			
		$data['q']=$dr['q'];
	} 

}
$data['count']=isset($data['rows'])? count($data['rows']):0;

if(!isset($_SESSION['terminals'])){ $_SESSION['terminals'] = fetchRows($db,"{$dbo}.terminals","*","id"); } 
$data['terminals'] 	= $_SESSION['terminals'];	

$where="WHERE role_id='".RSUPP."'";
$data['suppliers']=fetchRows($db,"{$dbo}.`00_contacts`","id,name","name",$where);
$data['page'] = "Manage Inventory by Terminal";

if(isset($_GET['suppid'])){
	$q="SELECT id AS suppid,name AS supplier FROM {$dbo}.`00_contacts` WHERE id='".$_GET['suppid']."' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();	
	$supplier=$row['supplier'];
} else {
	$supplier=NULL;
}

$data['supplier']=$supplier;

$vfile=isset($_GET['printable'])? 'invis/mitInvisPrintable':'invis/mitInvis';
// pr($vfile);
$this->view->render($data,$vfile);


}	/* fxn */



public function invlogs(){
require_once(SITE."functions/inventory.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
if(isset($_GET['filter'])){
	$get=$_GET;
	$data=getInvlogs($db,$get);

}	/* post */

$data['today']=$_SESSION['today'];
$data['suppliers']=$_SESSION['suppliers'];
$data['terminals']=fetchRows($db,"{$dbo}.terminals","*","id");
$this->view->render($data,'invis/invlogs');

}	/* fxn */



public function report(){
	$dbo=PDBO;	
	$db=&$this->model->db;
	// require_once(SITE.'functions/invis_report.php');
	if(isset($_GET['submit'])){
		pr($_GET);
		$params=$_GET;
		$rows = report($db,$params);
		pr($rows);
		exit;
		
		
	}

	$data['employees'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name','WHERE role_id = 10');	
	// $data['suppliers']=$_SESSION['suppliers'];		
	pr($data);
	$this->view->render($data,'invis/report');

}	/* fxn */









}	/* BlankController */
