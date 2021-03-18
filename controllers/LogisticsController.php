<?php

Class LogisticsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();		
	
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0),array(10,0)); 
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				

	
}



public function index($params=NULL){
require_once(SITE."functions/pos.php");
require_once(SITE."functions/logistics.php");
$db =& $this->model->db;$dbo=PDBO;
$get=$_GET;

$data=listsmv($db,$get);
$trml = myTerminal($db);
$data['t'] = $trml;


$tmax=$_SESSION['settings']['numterminals'];
if(!isset($_SESSION['terminals'])){ 
	$_SESSION['terminals'] = $this->model->fetchRows("{$dbo}.terminals","*","id","WHERE id<=$tmax");
} 
$data['terminals'] = $_SESSION['terminals'];

$this->view->render($data,'logistics/index');

}	/* fxn */



public function move(){	/* inter terminals */
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	$smv=$_POST['smv'];
	$rows=$_POST['smvd'];
	$year=DBYR;
	$lastId=lastId($db,"{$dbo}.`30_smv`");
	$smv_id=$lastId+1;
	
	$date = $smv['date'];
	$src = $smv['src'];
	$dest = $smv['dest'];
	$reference = $smv['reference'];
	$comments = $smv['comments'];
	
	$q = "INSERT IGNORE INTO {$dbo}.`30_smvdetails`(`smv_id`,`prid`,`roqty`,`rxqty`) VALUES ";	
	$q2="";
	foreach($rows AS $row){
		if($row['prid']>0){
			$q .= " ('$smv_id','".$row['prid']."','".$row['roqty']."','".$row['rxqty']."'),";	
			$q2.="UPDATE {$dbo}.`03_products` SET `t{$src}` = `t{$src}`-".$row['rxqty'].",`t{$dest}` = `t{$dest}`+".$row['rxqty'];
			$q2.=" WHERE `id`='".$row['prid']."' LIMIT 1; ";			
		}	/* if */		
	}	/* foreach */
	$q = rtrim($q,",");
	$q .= ";";	
	// pr($q);exit;
	$db->query($q2);
	$sth=$db->query($q);
 	if($sth){
		$q = "INSERT IGNORE INTO {$dbo}.`30_smv`(`year`,`id`,`date`,`src`,`dest`,`reference`,`comments`) 
			VALUES ('$year','$smv_id','$date','$src','$dest','$reference','$comments'); ";
		$sth = $db->querysoc($q);		
	} 
	$url="logistics/view/$smv_id";
	$msg="Stocks Movement created.";	
	flashRedirect($url,$msg);	
	exit;
	
}	/* post */

$data['terminals'] = $this->model->fetchRows("{$dbo}.terminals","*","id");

$date=date('Ymd',strtotime($_SESSION['today']));

$data['id']=(lastId($db,"{$dbo}.`30_smv`")+1);	
$data['reference']=$date.'-'.str_pad($data['id'],4,"0",STR_PAD_LEFT);
$this->view->render($data,'logistics/move');

}	/* fxn */


public function view($params){
$data['smvid'] = $smvid= $params[0];
$db=&$this->model->db;
$dbg = PDBG;
$dbg = PDBG;		
$dbo=PDBO;

$staff=($_SESSION['user']['privilege_id']!=0)? true:false;
if($staff && ($_SESSION['srid']!=RMIS)){	
	$t=$_SESSION['terminal'];	
	$smv=fetchRow($db,"{$dbo}.`30_smv`",$smvid);
	if(($smv['src']!=$t) && ($smv['dest']!=$t)) { flashRedirect('logistics/index','Terminal not assigned.'); }	
}	/* staff */

if($smvid){
	require_once(SITE."functions/logistics.php");	
	$data1 = getSmv($db,$smvid);	
	$data = array_merge($data,$data1);	
}	/* smvid */

$data['page']="Stocks Movement";
$this->view->render($data,'logistics/view');

}	/* fxn */



public function edit($params=NULL){
$data['smvid'] = $smvid = isset($params[0])?$params[0]:false;
$db =& $this->model->db;
$dbg = PDBG;
$dbg = PDBG;		

$staff=($_SESSION['user']['privilege_id']!=0)? true:false;
if($staff && ($_SESSION['srid']!=RMIS)){
	$t=$_SESSION['terminal'];
	$smv=fetchRow($db,"{$dbo}.`30_smv`",$smvid);
	if(($smv['src']!=$t) && ($smv['dest']!=$t)) { flashRedirect('logistics/index'); }	
}	/* staff */

	
if($smvid){
	require_once(SITE."functions/logistics.php");
	$data1 = getSmv($db,$smvid);
	$data = array_merge($data,$data1);
}	/* smvid */

if(isset($_POST['submit'])){
	$smv = $_POST['smv'];
	$sd = $_POST['sd'];
	$count=$data['count'];
	$src=$data['smv']['src'];
	$dest=$data['smv']['dest'];
	saveSmv($db,$smvid,$smv,$sd,$count,$src,$dest);	
	$url = "logistics/view/$smvid"; 
	flashRedirect($url,'Stocks Movement updated.');
	exit;
	
}	/* post */

$this->view->render($data,'logistics/edit');

}	/* fxn */



public function deleteSmv($params){
	require_once(SITE."functions/logs.php");
	$id=$params[0];
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.`30_smv` WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	
	$q="DELETE FROM {$dbo}.`30_smv` WHERE id='$id' LIMIT 1; ";
	$q.="DELETE FROM {$dbo}.`30_smvdetails` WHERE `smv_id`='$id'; ";
	$db->query($q);	
	/* 3 logs */	
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['delete_smv'];
	$details = "SMV Date: ".$row['date'].", Ref: ".$row['reference'].", TSrc: ".$row['src'].", TDest: ".$row['dest'];
	logThis($db,$ucid,$axn,$details,$more);			
	$url="logistics/index";
	flashRedirect($url,'Stock Movement Deleted.');

}	/* fxn */



public function filterTransfer(){	/* from PO to other terminal pmv */
$db=&$this->model->db;
$dbo=PDBO;$dbg = PDBG;

if(isset($_GET['filter'])){
	// pr($_GET);
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['supplier'])){ $cond .= " AND po.suppid = '".$get['supplier']."'"; }				
	if (!empty($get['terminal'])){ $cond .= " AND pd.terminal = '".$get['terminal']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND po.date >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND po.date <= '".$get['datetwo']."'"; }				
	if (!empty($get['reference'])){ $cond .= " AND po.reference LIKE '%".$get['reference']."%'"; }				
	if (!empty($get['invoice'])){ $cond .= " AND po.invoice LIKE '%".$get['invoice']."%'"; }				
	if (!empty($get['balance'])){ $cond .= " AND po.balance >= '".$get['balance']."'"; }				
	
	$limits = $get['limits'];
	$offset = ($get['page']-1)*$limits;
	$sort   = (isset($get['sort']))?$get['sort']:'tp.date';
	$order  = (isset($get['order']))?$get['order']:'DESC';
 			
	$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$q = "SELECT po.*,c.name AS supplier,po.id AS poid
		FROM {$dbo}.`30_po` AS po
			LEFT JOIN {$dbo}.`00_contacts` AS c ON po.suppid = c.id 
			LEFT JOIN {$dbo}.`30_pmvdetails` AS pd ON pd.poid = po.id ";	
		$q .= " WHERE 	1=1 $cond  GROUP BY pd.poid ";
		$q.=" ORDER BY $sort $order LIMIT $limits OFFSET $offset;";
	$data['q']=$q;
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= fetchRows($db,"{$dbo}.`00_contacts`",'id,parent_id,`name`','name',$where);			

}	
if(!isset($_SESSION['terminals'])){ $_SESSION['terminals'] = fetchRows($db,"{$dbo}.terminals","*","id"); } 
$data['terminals'] 	= $_SESSION['terminals'];	

$this->view->render($data,'logistics/filterTransfer');


}	/* fxn */



public function summaryTransfer(){

$db=&$this->model->db;$dbo=PDBO;$dbg = PDBG;
if(isset($_GET['filter'])){
	// pr($_GET);
	// exit;
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['supplier'])){ $cond .= " AND po.suppid = '".$get['supplier']."'"; }				
	if (!empty($get['prid'])){ $cond .= " AND pd.prid = '".$get['prid']."'"; }				
	if (!empty($get['terminal'])){ $cond .= " AND pd.terminal = '".$get['terminal']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND ( po.date >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND po.date <= '".$get['datetwo']."' ) "; }				 			
	$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$q = "SELECT po.suppid,c.name AS supplier,po.id AS poid,SUM(pd.mvqty) AS sumqty,p.name AS product,p.id AS prid,pd.terminal
		FROM {$dbo}.`30_po` AS `po`
			LEFT JOIN {$dbo}.`00_contacts` AS c ON po.suppid = c.id 
			LEFT JOIN {$dbo}.`30_pmvdetails` AS pd ON pd.poid = po.id 
			LEFT JOIN {$dbo}.`03_products` AS p ON pd.prid = p.id ";	
		$q .= " WHERE 	1=1 $cond  GROUP BY pd.terminal,pd.prid 
			ORDER BY c.name,p.name,pd.terminal ASC; ";	
	$data['q']=$q;
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			

}	
if(!isset($_SESSION['terminals'])){ $_SESSION['terminals'] = fetchRows($db,"{$dbo}.terminals","*","id"); } 
$data['terminals'] 	= $_SESSION['terminals'];	

$this->view->render($data,'logistics/summaryTransfer');


}	/* fxn */




public function summary($params=NULL){
require_once(SITE."functions/pos.php");
require_once(SITE."functions/logistics.php");
$db =& $this->model->db;$dbo=PDBO;
$get=$_GET;

$data=listsmvsummary($db,$get);
$trml = myTerminal($db);
$data['t'] = $trml;


$tmax=$_SESSION['settings']['numterminals'];
if(!isset($_SESSION['terminals'])){ 
	$_SESSION['terminals'] = $this->model->fetchRows("{$dbo}.terminals","*","id","WHERE id<=$tmax");
} 
$data['terminals'] = $_SESSION['terminals'];

$this->view->render($data,'logistics/summaryLogistics');

}	/* fxn */


public function smvpridItemized($params){
	require_once(SITE."functions/logistics.php");
	$db =& $this->model->db;$dbg=PDBG;$dbo=PDBO;
	$prid=$params[0];
	$data=getsmvpridItemized($db,$prid);
	$this->view->render($data,'logistics/smvpridItemized');

}	/* fxn */





}	/* LogisticsController */
