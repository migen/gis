<?php

Class StocksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data=NULL;	
	$this->view->render($data,'stocks/index');

}	/* fxn */


public function reset($params){
$dbo=PDBO;
	$ctlr 	= $params[0];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1] : $ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;		
	$this->model->sessionizeStock($dbg);	
	redirect($ctlr);
} 	/* fxn */




public function dtr($params=NULL){
require_once(SITE."functions/pos.php");

$db=&$this->model->db;$dbo = PDBO;
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;


$data['srid'] = $srid = $_SESSION['srid'];
$data['prid'] = $prid = $_SESSION['user']['privilege_id'];
$data['admin'] = $admin = ($prid==0)? true:false;
$data['today'] = $today = $_SESSION['today'];

/* params = trml,date,ecid */
$dtrml = isset($_GET['terminal'])? $_GET['terminal']:1;
$terminal = ($admin)? $dtrml:myTerminal($db);
$data['terminal'] = $terminal;

$data['start'] = $start = isset($_GET['start'])? $_GET['start']:$today;
$data['end'] = $end = isset($_GET['end'])? $_GET['end']:$today;

$ecid = (isset($_GET['ecid']))? $_GET['ecid']:$_SESSION['ucid'];
$data['ecid'] = $ecid;

$where=" WHERE `role_id`='".RINVIS."' ";
$data['cashiers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name',$where);


/* 5 record */
$cond="";
if (isset($_GET['terminal']) && ($_GET['terminal']==0)){ } else { $cond.="AND p.terminal='$terminal' "; }
if (isset($_GET['ecid']) && ($_GET['ecid']==0)){ } else { $cond.="AND p.`ecid`='$ecid' "; }
$cond.=" AND DATE(p.datetime)>='$start' AND DATE(p.datetime)<='$end' "; 
if (isset($_GET['paid']) && ($_GET['paid']==1)){ $cond.="AND p.is_paid='1' "; }


$q = " SELECT pr.id AS prodid,pr.level,SUM(pd.qty) AS sold,SUM(pd.qty*pd.price) AS revenue,
	pr.name AS product,p.is_paid,pr.barcode,pr.cost,pr.suppid,c.name AS supplier,
	AVG(pd.price) AS price,AVG(pd.cost) AS cost ";
if($terminal>0){ $q.=",pr.t{$terminal} AS tq "; }

$q.=" FROM {$dbo}.`30_pos` AS p 
	LEFT JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id = p.id
	LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
	LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid = c.id
	WHERE 1=1 $cond GROUP BY pr.id 
	ORDER BY supplier,pr.name
;";
$data['q']=$q;
$sth = $this->model->db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);


$q=" SELECT SUM(p.total) AS `pos_total` FROM {$dbo}.`30_pos` AS p WHERE 1=1 $cond ; ";
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
$data['pos_total'] = $pos_total = $row['pos_total']; 

if($ecid>0){
	$q = "SELECT c.*,c.id AS ecid,c.name AS employee,te.terminal FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`03_terminals_employees` AS te ON te.ecid=c.id WHERE c.`id` = '$ecid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$data['employee'] = $sth->fetch();
}

$data['page']="Daily Terminal Report (Stocks DTR)";
$this->view->render($data,'stocks/dtr');


}	/* fxn */



public function byTerminal(){
require_once(SITE."functions/pos.php");
require_once(SITE."functions/serverFxn.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
$sort = isset($_GET['sort'])? $_GET['sort']:'c.name,pr.name';
$order = isset($_GET['order'])? $_GET['order']:'ASC';

$data['srid'] = $srid = $_SESSION['srid'];
$data['prid'] = $prid = $_SESSION['user']['privilege_id'];
$data['staff'] = $staff = ($prid==1)? true:false;

$etrml = myTerminal($db);
// $terminal = (isset($_GET['terminal']) && ($_GET['terminal']!=0))? $_GET['terminal']:$etrml;
$terminal = isset($_GET['terminal'])? $_GET['terminal']:$etrml;
$terminal = ($staff)? $etrml:$terminal;
$data['terminal'] = $terminal;

$ucid = isset($params[1])? $params[1]:$_SESSION['ucid'];
$ucid = ($staff)? $_SESSION['ucid']:$ucid;
$data['ucid'] = $ucid;
$data['today'] = $today = $_SESSION['today'];

if(isset($_POST['submit'])){		
	$url=$_SERVER['REDIRECT_QUERY_STRING'];
	$url=ltrim($url,"url=");	
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$q.="UPDATE {$dbg}.03_products SET `cost`='".$post['cost']."',
			`price`='".$post['price']."',`t{$terminal}`='".$post['tq']."',`level`='".$post['lq']."'			
			WHERE `id`='".$post['prid']."' LIMIT 1; ";	
	}
	// pr($q);exit;
	$sth=$db->query($q);
	$msg=($sth)? "Success":"Fail";
	flashRedirect($url,$msg);	
	exit;	
	
}	/* save */


$params=$_GET;
$cond="";
if (!empty($params['display'])){ $cond .= " AND pr.in_t{$terminal} = '1' "; }				
if (!empty($params['suppid'])){ $cond .= " AND pr.suppid = '".$params['suppid']."'"; }				

if(!empty($params['signed']) && ($params['signed']==1)){
	if (!empty($params['qty'])){ $cond .= " AND pr.t{$terminal} > '".$params['qty']."'"; 
	} else { $cond .= " AND pr.t{$terminal} = '0'"; } 				
	
	if (isset($params['tqupper'])){ $cond .= " AND pr.t{$terminal} < '".$params['tqupper']."'"; }  					
} 


if (!empty($params['product'])){ $cond .= " AND pr.name LIKE '%".$params['product']."%'"; }				
if (!empty($params['code'])){ $cond .= " AND (pr.code LIKE '%".$params['code']."%' 
	|| pr.barcode LIKE '%".$params['code']."%')"; }				
$q = " SELECT pr.id AS prodid,pr.t{$terminal} AS tq,pr.level,pr.name AS product,pr.*,c.name AS supplier
	FROM {$dbo}.`03_products` AS pr LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid=c.id
	WHERE 1=1 $cond ORDER BY $sort $order ;";
$data['q']=$q;
	
if(isset($_GET['submit'])){
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
} else {
	$data['rows']=NULL;$data['count']=0;
}

$data['suppliers'] = $_SESSION['suppliers'];		


$vfile=isset($_GET['printable'])? 'stocks/byTerminalStocksPrintable':'stocks/byTerminalStocks';
// pr($vfile);
$this->view->render($data,$vfile);



}	/* fxn */


public function move(){
$db=&$this->model->db;
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	// pr($_POST);
	$smv=$_POST['smv'];
	$rows=$_POST['smvd'];	
	$lastId=lastId($db,"{$dbo}.`30_smv`");
	$smv_id=$lastId+1;
	$year=DBYR;
	// pr($lastId);
	$q = "INSERT IGNORE INTO {$dbo}.`30_smv`(`year`,`smv_id`,`prid`,`qty`) VALUES ";	
	foreach($rows AS $row){
		if($row['prid']>0){
			$q .= " ('$year','$smv_id','".$row['prid']."','".$row['qty']."'),";			
		}	/* if */		
	}	/* foreach */
	$q = rtrim($q,",");
	$q .= ";";
	$sth=$db->query($q);
 	if($sth){
		$date = $smv['date'];
		$src = $smv['src'];
		$dest = $smv['dest'];
		$reference = $smv['reference'];
		$comments = $smv['comments'];

		$q = "INSERT IGNORE INTO {$dbg}.smv(`year`,`id`,`date`,`src`,`dest`,`reference`,`comments`) 
			VALUES ('$year','$smv_id','$date','$src','$dest','$reference','$comments'); ";
		// pr($q);exit;
		$sth = $db->querysoc($q);		
		return $poid;	
	} else {		
		return false;
	}

	$url="stocks/movement/$smv_id";		
	
	exit;
	
}	/* post */

$data['terminals'] = $this->model->fetchRows("{$dbg}.terminals","*","id");
$this->view->render($data,'stocks/move');

}	/* fxn */


public function movement($params){
$data['id'] = $id= $params[0];



}	/* fxn */


public function display($params=NULL){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

$srid=$_SESSION['srid'];
$admin=(($srid==RINVIS) && ($_SESSION['user']['privilege_id']==0) || ($srid==RMIS))? true:false;
$editable=($admin || ($_SESSION['settings']['staffinvis_setup']==1))? true:false;
$data['editable']=$editable;

require_once(SITE."functions/inventory.php");

$t=NULL;
$cond=NULL;
$data['suppid']=$suppid=isset($params[0])? $params[0]:false;

if($suppid){
	$cond .= " AND pr.suppid = '$suppid' "; 
	$dr=getProductsBySupplier($db,$t,$cond,$sort="pr.name",$order="ASC");			
	$data['rows']=$dr['rows'];			
	$data['q']=$dr['q'];
}


if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$prid=$post['prid'];		
		$in_t1=$post['in_t1'];$in_t2=$post['in_t2'];$in_t3=$post['in_t3'];
		$in_t4=$post['in_t4'];$in_t5=$post['in_t5'];$in_t6=$post['in_t6'];
		$q.="UPDATE {$dbo}.`03_products` SET `in_t1`='$in_t1',`in_t2`='$in_t2',`in_t3`='$in_t3',
			`in_t4`='$in_t4',`in_t5`='$in_t5',`in_t6`='$in_t6' WHERE `id`='$prid' LIMIT 1;";
	}
	// pr($q); exit;
	$db->query($q);
	$url="stocks/display/$suppid";
	redirect($url);
	exit;
	
}	/* post */

$data['count']=isset($data['rows'])? count($data['rows']):0;
$where="WHERE role_id='".RSUPP."'";
$data['suppliers']=fetchRows($db,"{$dbo}.`00_contacts`","id,name","name",$where);

$this->view->render($data,'stocks/displayStocks');

}	/* fxn */




public function stats(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$q="
	SELECT c.name AS supplier,
		count(pr.id) AS numrows
	FROM {$dbo}.`03_products` AS pr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid=c.id
	GROUP BY pr.suppid ORDER BY c.name,pr.name;
		
";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,'stocks/stats');

}	/* fxn */











}	/* StocksController */
