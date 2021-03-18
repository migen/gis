<?php

Class CashController extends Controller{	

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
	// echo "Cash Home";
	$this->view->render($data,'cash/index');

}	/* fxn */




public function tally($params=NULL){	/* payments and bills - enrollment */
require_once(SITE."functions/nextsy.php");
require_once(SITE."functions/cash.php");
$db=&$this->model->db;
$sy=DBYR;$dbg=PDBG;$dbo=PDBO;
$nsy=$sy+1;
$ndbm=VCPREFIX.$nsy.US.DBG;$ndbg=VCPREFIX.$nsy.US.DBG;

$has_pdbg=($_SESSION['settings']['sy_end']>$_SESSION['settings']['sy_beg'])? 1:0;

$data['rows'] = $this->model->fetchRows("{$dbo}.`03_denominations`","*","realvalue DESC");
$data['count'] = count($data['rows']); 
$data['ecid'] = $ecid = (isset($_GET['ecid']))? $_GET['ecid']:$_SESSION['ucid'];
$data['today'] = $today = $_SESSION['today'];

$ddate = (isset($_GET['date']))? $_GET['date']:$today;
$date = $ddate;
$data['date'] = $date;

if(isset($_GET['filter'])){
	$ecid=$_GET['ecid'];
	$date=$_GET['date'];
	$url="cash/tally?ecid=$ecid&date=$date";
	redirect($url);
	exit;
}	/* get */


/* 1 cash */
$data['row'] = $row = fetchRecord($db,"{$dbg}.`30_cash`","date='$date' AND `ecid` = '$ecid' ");
$exists = (empty($row))? false:true;
$data['terminal'] = 1;

$has_ndbg=dbgExists($db,$nsy);
$data['cash_total']=$data['cash_sales']=payTotal($db,$ecid,$date,$paytype_id=1,$has_ndbg,$has_pdbg);

/* 2.2 - check sales */

$data['check']=$data['check']=payTotal($db,$ecid,$date,$paytype_id=2,$has_ndbg,$has_pdbg);
$data["check_sales"] = payDetails($db,$ecid,$date,$paytype_id,$has_ndbg);	

$data['deposit']=$data['deposit']=payTotal($db,$ecid,$date,$paytype_id=3,$has_ndbg,$has_pdbg);
$data["deposit_sales"] = payDetails($db,$ecid,$date,$paytype_id=3,$has_ndbg);	


/* 5 */
$data1=ordata($db,$date);
$data=array_merge($data,$data1);	
$data['total_sales']=$data['cash_total']+$data['check']+$data['deposit'];

$data['home'] = $_SESSION['home'];

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$posts['ecid'] = $data['ecid'];
	$posts['date'] = $data['date'];
	
	unset($posts['submit']);
	$total=0;
	foreach($posts AS $k=>$v){
		$pk = str_replace('c','.',$k);
		$total+=($pk*$v);		
	}	/* foreach */
	$posts['cash'] = $total;

	if($exists){
		$db->update("{$dbg}.`30_cash`",$posts,"`date`='$date'");
	} else {
		$db->add("{$dbg}.`30_cash`",$posts);
	}
	$url = "cash/tally?date=$date";
	flashRedirect($url,'Cash tallied.');	
	exit;

}	/* fxn */
// pr($data);
$this->view->render($data,'cash/tally');

}	/* fxn */



public function denominations($params=NULL){	/* pos transactions */
require_once(SITE."functions/pos.php");
$db=&$this->model->db;
$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['rows']=fetchRows($db,"{$dbo}.`03_denominations`","*","realvalue DESC");
$data['admin']=$admin=($_SESSION['user']['privilege_id']==0)? true:false;

$data['count'] = count($data['rows']); 
$data['ecid'] = $ecid = $_SESSION['pcid'];
$data['today'] = $today = $_SESSION['today'];
/* 1 */
// $data['terminal'] = $terminal = (isset($_GET['terminal']))? $_GET['terminal']:1;

/* params = trml,date,ecid */
$dtrml = isset($_GET['terminal'])? $_GET['terminal']:1;
$terminal = ($admin)? $dtrml:myTerminal($db);
$data['terminal'] = $terminal;

$ddate = (isset($_GET['date']))? $_GET['date']:$today;
$date=&$ddate;
// $date = ($admin)? $ddate:$today;
$data['date'] = $date;

$decid = (isset($_GET['ecid']))? $_GET['ecid']:$_SESSION['ucid'];
$ecid = ($admin)? $decid:$_SESSION['ucid'];
$data['ecid'] = $ecid;

if($admin){
	$where=" WHERE `role_id`='".RINVIS."' ";
	$data['cashiers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name',$where);
}	/* empls */


/* 3 record */
$where="date='$date' AND `terminal` = '$terminal' AND `ecid` = '$ecid' ";
// $data['row'] = $row = $this->model->fetchRecord("{$dbg}.`30_cash`",$where);
$data['row'] = $row = fetchRecord($db,"{$dbg}.`30_cash`",$where);
$exists = (empty($row))? false:true;


/* 2 */
if(!isset($_SESSION['paytypes'])){ 
	$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*"); 	 } 
$data['paytypes'] = $paytypes = $_SESSION['paytypes'];	


$cond="";
if (isset($_GET['terminal']) && ($_GET['terminal']==0)){ } else { $cond.="AND p.terminal='$terminal' "; }
if (isset($_GET['ecid']) && ($_GET['ecid']==0)){ } else { $cond.="AND p.`ecid`='$ecid' "; }
if (isset($_GET['date']) && ($_GET['date']==0)){ } else { $cond.="AND DATE(p.datetime)='$date' "; }
if (isset($_GET['paid']) && ($_GET['paid']==0)){ } else { $cond.="AND p.is_paid='1' "; }

debug($cond,"Cond for total sales");
$q = " SELECT sum(p.total) AS `dsr`
	FROM {$dbo}.`30_pos` AS p
	WHERE 1=1 $cond ; ";
debug($q,"cash-denominations: total_sales");	
$sth = $db->querysoc($q);
$srows = $sth->fetch();
$data["total_sales"] = $total_sales = $srows['dsr'];	

$data['home'] = $_SESSION['home'];

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];	
	
	unset($posts['submit']);
	$total=0;
	foreach($posts AS $k=>$v){
		$pk = str_replace('c','.',$k);
		$total+=($pk*$v);		
	}	/* foreach */
	$posts['cash'] = $total;
	
	$posts['terminal'] = $terminal;
	$posts['ecid'] = $ecid;
	$posts['date'] = $date;	

	if($exists){
		$where=" `terminal`='$terminal' AND `ecid`='$ecid' AND `date`='$date' ";
		$db->update("{$dbg}.`30_cash`",$posts,$where);
	} else {
		$db->add("{$dbg}.`30_cash`",$posts);
	}
	$url = "cash/denominations?date={$date}&terminal={$terminal}&ecid={$ecid}";
	flashRedirect($url,'Cash tallied.');	
	exit;

}	/* fxn */

$data['page']="Daily Cash Denominations";


/* 2 cheques */
/* checks details */
// p.`paytype_id` = '2' AND
$q = "SELECT p.*,c.name AS student,b.name AS bank 
		FROM {$dbo}.`30_pos` AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid = c.id 
		LEFT JOIN {$dbo}.`03_banks` AS b ON p.bank_id = b.id 		
		WHERE p.tenderetc>0 $cond; ";
		
		// pr($q);
debug($q,"cash-denominations: cheques rows ");	
$sth = $this->model->db->querysoc($q);
$data['cheques']=$cheques = $sth->fetchAll();
$data['num_cheques']=$num_cheques=count($cheques);
debug($cond,"Cond for cheque sales");
$q="SELECT SUM(p.tenderetc) AS cheque_sales FROM {$dbo}.`30_pos` AS p 
	WHERE p.tenderetc>0 $cond; ";
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
$data['cheque_sales']=$cheque_sales=$row['cheque_sales'];	
$data['cash_sales']=$cash_sales=$total_sales-$cheque_sales;	

$this->view->render($data,'cash/denominations');

}	/* fxn */


















}	/* CashController */
