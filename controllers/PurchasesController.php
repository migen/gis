<?php

Class PurchasesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	echo "purchases ctlr";
	$this->view->render($data,'tests/index');

}	/* fxn */




public function filterPO(){
$dbo=PDBO;

if(isset($_GET['filter'])){
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['supplier'])){ $cond .= " AND po.suppid = '".$get['supplier']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND po.date >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND po.date <= '".$get['datetwo']."'"; }				
	if (!empty($get['reference'])){ $cond .= " AND po.reference LIKE '%".$get['reference']."%'"; }				
	if (!empty($get['invoice'])){ $cond .= " AND po.invoice LIKE '%".$get['invoice']."%'"; }				
	if (!empty($get['balance'])){ $cond .= " AND po.balance >= '".$get['balance']."'"; }				
	
	$limits = $get['limits'];
	$offset = ($get['page']-1)*$limits;
	$sort   = (isset($get['sort']))?$get['sort']:'tp.date';
	$order  = (isset($get['order']))?$get['order']:'DESC';
 			
	$data['sy']=$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	$q = "SELECT po.*,c.name AS supplier,po.id AS poid
		FROM {$dbo}.`30_po` AS `po`
			LEFT JOIN {$dbo}.`00_contacts` AS c ON po.suppid = c.id ";	
		$q .= " WHERE 	1=1 $cond  ORDER BY $sort $order LIMIT $limits OFFSET $offset ; ";			
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			

}	

$this->view->render($data,'purchases/filterPO');


}	/* fxn */



public function viewPO($params=NULL){
$dbo=PDBO;
$data['poid'] = $poid = isset($params[0])?$params[0]:false;
$data['sy'] = $sy = isset($params[1])?$params[1]:DBYR;

if($poid){
	require_once(SITE."functions/poFxn.php");
	$db =& $this->model->db;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
	$data = getPO($db,$dbg,$poid);
} else { redirect('purchases/filterPO'); }

$data['poid'] = $poid;
$data = isset($data)? $data:NULL;
$data['page']="Purchase Order";

$this->view->render($data,'purchases/viewPO');

}	/* fxn */



public function editPO($params=NULL){
$dbo=PDBO;
$data['poid'] = $poid = isset($params[0])?$params[0]:false;
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
	
if($poid){
	require_once(SITE."functions/poFxn.php");
	$db =& $this->model->db;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	
	$data = getPO($db,$dbg,$poid);
	$suppid = $data['row']['suppid'];
	$data['count'] = $count = count($data['rows']);

}	/* poid */

if(isset($_POST['submit'])){
	// pr($_POST);
	// exit;
	$po = $_POST['po'];
	$pd = $_POST['pd'];
	$pays = isset($_POST['pays'])? $_POST['pays']:NULL; 	
	$payment = $_POST['payment'];
	$t=$_POST['po']['terminal'];
	savePO($db,$dbg,$poid,$po,$pd,$count,$pays,$payment,$t);	
	$url = "purchases/viewPO/$poid"; 
	flashRedirect($url,'PO updated.');
	exit;
	
}	/* post */


$data['poid'] = $poid;
$data['terminals'] = $this->model->fetchRows("{$dbo}.terminals","*","id");
$this->view->render($data,'purchases/editPO');


}	/* fxn */




public function deletePO($params){
$dbo=PDBO;
	require_once(SITE."functions/logs.php");
	$data['id'] = $id = isset($params[0])?$params[0]:false;
	$data['sy'] = $sy = isset($params[1])?$params[1]:DBYR;
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT * FROM {$dbo}.`30_po` WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	
	$q="DELETE FROM {$dbo}.`30_po` WHERE id='$id' LIMIT 1; ";
	$q.="DELETE FROM {$dbo}.`30_podetails` WHERE `po_id`='$id'; ";
	$db->query($q);
	
	/* 3 logs */
	
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['delete_po'];
	$details = "PO Date: ".$row['date'].", Ref: ".$row['reference'];
	$more['amount'] = $row['total'];
	$more['ecid'] = $row['ecid'];
	logThis($db,$ucid,$axn,$details,$more);	
		
	$url="purchases/filterPO";
	flashRedirect($url,'PO Deleted.');

}	/* fxn */



public function addPO(){
$db=&$this->model->db;
$dbo=PDBO;$dbg=PDBG;

if(isset($_POST['submit'])){
	$data=$_POST['po'];
	$table="{$dbo}.`30_po`";	
	$data['year']=DBYR;
	$date=preg_replace("([^0-9/])", "", $data['date']);
	unset($data['suppname']);	
	$data['id']=(lastId($db,"{$dbo}.30_po")+1);	
	$data['reference']=$date.'-'.str_pad($data['suppid'],4,"0",STR_PAD_LEFT).'-'.str_pad($data['id'],4,"0",STR_PAD_LEFT);
	$db->add($table,$data);
	$poid=$db->lastInsertId();
	$url="purchases/editPO/$poid";
	redirect($url);	
	exit;
}

$where = "WHERE role_id = '".RSUPP."'";
$data['suppliers']	= fetchRows($db,"{$dbo}.`00_contacts`",'id,parent_id,`name`','name',$where);			

$this->view->render($data,'purchases/addPO');

}	/* fxn */



public function movePO($params=NULL){
$dbo=PDBO;
$poid = isset($params[0])?$params[0]:false;

if($poid){
	require_once(SITE."functions/poFxn.php");
	$db =& $this->model->db;
	$dbg = PDBG;$dbg = PDBG;	 
	$data = podetails($db,$dbg,$poid);

} else {
	redirect('purchases/filterPO');
}

$data['poid'] = $poid;
$data = isset($data)? $data:NULL;
$data['page']="Purchase Order";
$data['t']=$data['row']['terminal'];
$this->view->render($data,'purchases/movePO');

}	/* fxn */



public function posumm(){
$dbo=PDBO;
require_once(SITE."functions/poFxn.php");
$db=&$this->model->db;
$dbg = PDBG;

if($_SESSION['user']['privilege_id']>0) { flashRedirect('index','Privilege not authorized.'); }

if(isset($_GET['submit'])){
	$params = $_GET;	
	$data = posumm($db,$params);		
	$data['params'] = $params;		
			
}	/* post */

$data['employees'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name','WHERE role_id = 10');	
$data['suppliers']=$_SESSION['suppliers'];		
$this->view->render($data,'purchases/posummPurchases');



}	/* fxn */


public function editPOSupplier($params=NULL){
$dbo=PDBO;
$poid=isset($params[0])? $params[0]:false;
$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$home=$_SESSION['home'];
if(!$poid){ flashRedirect($home,'No po id.'); }


$q="SELECT p.id AS poid,p.*,c.name AS supplier FROM {$dbo}.`30_po` AS p
LEFT JOIN {$dbo}.`00_contacts` AS c ON p.suppid=c.id
WHERE p.id='$poid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

if(isset($_POST['submit'])){
	// pr($_POST);exit;
	$post=$_POST;
	if($row['suppid']!=$post['suppid']){
		$q="UPDATE {$dbo}.`30_po` SET `suppid`='".$post['suppid']."' WHERE `id`='$poid' LIMIT 1;";
		$db->query($q);
	}
	$url="purchases/viewPO/$poid";
	flashRedirect($url,'PO Supplier updated');
}	/* post */


$data['suppliers']=$_SESSION['suppliers'];
$this->view->render($data,'purchases/editPOSupplier');

}	/* fxn */






}	/* PurchasesController */
