<?php

Class BillsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function add(){
$dbo=PDBO;
if(isset($_POST['submit'])){	
	$ucid=$_POST['ucid'];
	$btn=$_POST['submit'];
	if($btn!='Misc'){
		$url="ledgers/pay/$ucid";
	} else {
		$params=($ucid>0)? $ucid:$_POST['name'];
		$url="bills/pay/$params";
	}
	redirect($url);
	exit;
}	/* fxn */

$data=NULL;
$this->view->render($data,'bills/add');
}	/* fxn */


public function pay($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/bills.php");
$payer=(isset($params[0]))? $params[0]:false;
$db=&$this->model->db;
$ecid=$_SESSION['ucid'];

if(ctype_digit($payer)){
	$data['row'] = $row=fetchRow($db,"{$dbo}.`00_contacts`",$payer);
	$data['ucid']=$ucid=$row['id'];
	$data['name']=$row['name'];
} else {
	$data['ucid']=$ucid=false;
	$data['name']=$payer;
	
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	payBill($db,$ecid,$ucid,$post,$payer);	
	$orno=trim($post['orno']);
	$url="invoices/printorno/$orno";
	redirect($url);
	exit;
	
}	/* post */

$data['last_orno'] = $last_orno = $_SESSION['orno'];
$data['orno']=$_SESSION['orno'];
$data['feetypes']=$_SESSION['feetypes'];
$data['paytypes']=$_SESSION['paytypes'];
$data['banks']=$_SESSION['banks'];
$this->view->render($data,'bills/pay');


}	/* fxn */



public function index(){
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$get=$_GET;
if(isset($_GET['filter'])){
	$page = $get['page'];
	$limits = $get['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 		

	$cond="";
	if(!empty($get['start'])){ $cond.=" AND p.date >= '".$get['start']."' "; } 
	if(!empty($get['end'])){ $cond.=" AND p.date <= '".$get['end']."' "; } 
	if(!empty($get['scid'])){ $cond.=" AND p.scid = '".$get['scid']."' "; } 
	if(!empty($get['fee'])){ $cond.=" AND p.feetype_id = '".$get['fee']."' "; } 
	if(!empty($get['paytype'])){ $cond.=" AND p.paytype_id = '".$get['paytype']."' "; } 

$q="
	SELECT p.*,if(p.scid=0,p.payer,c.name) AS customer,f.name AS feetype,t.name AS paytype
	FROM {$dbo}.30_payments_bills AS p 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid=c.id
		LEFT JOIN {$dbo}.`03_feetypes` AS f ON p.feetype_id=f.id
		LEFT JOIN {$dbo}.`03_paytypes` AS t ON p.paytype_id=t.id
	WHERE 1=1 $cond
	ORDER BY p.date DESC $condlimits ;
";
$sth=$db->query($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
	
}	/* filter */


$data['page'] = $page = isset($page)? $page : '1';
$data['limits'] = $limits = isset($limits)? $limits : '20';
$data['today'] = $_SESSION['today'];

$data['paytypes'] = $_SESSION['paytypes'];
$data['feetypes'] = $_SESSION['feetypes'];
$this->view->render($data,'bills/indexBills');

} 	/* fxn */
















}	/* BillsController */
