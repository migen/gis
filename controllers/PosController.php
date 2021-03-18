<?php

Class PosController extends Controller{	

protected $dbg = PDBG;
protected $limits = LIMITS;

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}



public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();			

	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(RMIS,0),array(RINVIS,0),array(RADMIN,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl,0);				
		
}

public function index(){ redirect('npos'); }



public function edit($params){
$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	$pos_id = $params[0];	
	$db=&$this->model->db;$dbg=PDBG;

	if(isset($_POST['submit'])){
		$posts = $_POST;
		$old = $posts['positems'];
		$this->model->edit($posts,$old);
		flashRedirect('pos/view/'.$pos_id,'Sale updated.');		
		exit;
	}	/* post */
		
	$data = viewPos($pos_id,$db);
	$data['numrows'] = count($data['positems']);
	$data['selects'] = selectsPos($db,$dbg);	
	$data['terminal'] = $this->model->myTerminal();	
	$data['limits'] = $_SESSION['settings']['limits'];	
	$data['pos_id'] = $pos_id;
	$this->view->render($data,'pos/edit');

}	/* fxn */


public function terminals($params=NULL){
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$q = "SELECT et.*,c.name AS employee,et.id AS pkid,c.code FROM {$dbo}.`03_terminals_employees` AS et
		LEFT JOIN {$dbo}.`00_contacts` AS c ON et.ecid = c.id;";
debug($q);
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);
$this->view->render($data,'pos/terminals');

}	/* fxn */



public function delete($params){
$dbo=PDBO;
	require_once(SITE."functions/logs.php");
	$db=&$this->model->db;$dbg=PDBG;
	$pos_id=$params[0];
	
	/* 1 */
	$q = "SELECT * FROM {$dbo}.`30_pos` WHERE `id` = '$pos_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();

	/* 2 */
	$q = "	DELETE a,b from {$dbo}.`30_pos` AS a 
			INNER JOIN {$dbo}.`30_positems` AS b on b.pos_id = a.id
		WHERE a.id = '$pos_id'; ";
	$db->query($q);

	/* 3 logs */
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['delete_pos'];
	$details = "POS Date: ".$row['datetime'].", Trml: ".$row['terminal'].", Cashier: ".$row['ecid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $row['ccid'];
	$more['orno'] = $row['orno'];
	$more['amount'] = $row['total'];
	logThis($db,$ucid,$axn,$details,$more);	

	$url="npos";
	flashRedirect($url,'POS Deleted.');

}	/* fxn */


public function sales(){
$dbo=PDBO;
require_once(SITE."functions/posr.php");
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if($_SESSION['user']['privilege_id']>0) { flashRedirect('index','Privilege not authorized.'); }

	if(isset($_POST['cancel'])){
		unset($_POST);
		redirect('pos/sales');
	}	/* cancel */

	if(isset($_POST['submit'])){
		$params = $_POST;	
		// pr($params);exit;
		$data = salesReport($db,$params);		
		$data['params'] = $params;		
				
	}	/* post */
	
	$data['employees'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name','WHERE role_id = 10');	
	$data['suppliers']=$_SESSION['suppliers'];	
	$this->view->render($data,'pos/sales');


}	/* fxn */


public function items(){
$dbo=PDBO;
require_once(SITE."functions/posr.php");
$db=&$this->model->db;$dbg=PDBG;

if($_SESSION['user']['privilege_id']>0) { flashRedirect('index','Privilege not authorized.'); }

	if(isset($_POST['cancel'])){
		unset($_POST);
		redirect('pos/items');
	}	/* cancel */

	if(isset($_POST['submit'])){
		$params = $_POST;
		$data = itemsReport($db,$params);				
		$data['params'] = $params;		
		
	}	/* post */
		
	
	$data['employees'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name','WHERE role_id = 10');	
	$data['prodtags'] = $_SESSION['prodtags'];
	$data['prodtypes'] = $_SESSION['prodtypes'];
	$data['prodsubtypes'] = $_SESSION['prodsubtypes'];
	$data['comm'] = $_SESSION['comm'];
	$data['page']=(isset($data['params']) && ($data['params']['is_return']==1))? "Returns Report":"Inventory Items Report"; 
	$data = isset($data)? $data:NULL;
	$this->view->render($data,'pos/items');


}	/* fxn */


public function reconcile($params=NULL){
$dbo=PDBO;
$today = $_SESSION['today'];
$date = isset($params[0])? $params[0]:$today;
$fxn = isset($_GET['fxn'])? true:false;
$db=&$this->model->db;$dbg=PDBG;

$q="UPDATE {$dbo}.`30_pos` AS a
	INNER JOIN (
		SELECT
			p.id AS pos_id,b.total
		FROM {$dbo}.`30_pos` AS p 
		INNER JOIN (
			SELECT 		
				pos_id,sum(pd.amount) AS total 
			FROM {$dbo}.`30_positems` AS pd 
			GROUP BY pos_id			
		) AS b ON b.pos_id = p.id
		WHERE DATE(p.datetime) = '$date'	
	) AS c ON a.id = c.pos_id
	SET a.total = c.total; ";
$db->query($q);

if(!$fxn){
	$url="";
	flashRedirect($url,"Reconciled POS date - $date !");
}

}	/* fxn */


public function cancelx($params){
$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	$db =& $this->model->db;$dbg=PDBG;	
	$pos_id = $params[0];
	$data=viewPos($pos_id,$db);
	
	if(isset($_POST['submit'])){
		$posts = $_POST;
		$id = add($db,$posts);				
		$url = "npos/view/$id";
		flashRedirect($url,"POS Txn Cancelled.");		
		exit;
	}
	
	$data['count'] = count($data['positems']);
	$this->view->render($data,'pos/cancel');


}	/* fxn */


public function dsr($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/pos.php");
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

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

$decid = (isset($_GET['ecid']))? $_GET['ecid']:$_SESSION['ucid'];
$data['ecid'] = $ecid = $decid;

$where=" WHERE `role_id`='".RINVIS."' ";
$data['cashiers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name',$where);

/* 5 record */
$cond="";
if (isset($_GET['terminal']) && ($_GET['terminal']==0)){ } else { $cond.="AND p.terminal='$terminal' "; }
if (isset($_GET['ecid']) && ($_GET['ecid']==0)){ } else { $cond.="AND p.`ecid`='$ecid' "; }
$cond.=" AND DATE(p.datetime)>='$start' AND DATE(p.datetime)<='$end' "; 	
if (isset($_GET['paid']) && ($_GET['paid']==0)){ } else { $cond.="AND p.is_paid='1' "; }

$q = " SELECT sum(p.total) AS `dsr` FROM {$dbo}.`30_pos` AS p WHERE 1=1 $cond; ";
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
$data['pos_total'] = $row['dsr'];

$q = "
SELECT sum(pd.qty*pd.price) AS `dsr`
FROM {$dbo}.`30_pos` AS p 
	LEFT JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id = p.id
	LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
WHERE 1=1 $cond;
";

// pr($_GET);
// pr($q);
$data['q']=$q;
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
$data['inventory_total'] = $row['dsr'];

if($ecid>0){
	$q = "SELECT c.*,c.id AS ecid,c.name AS employee,te.terminal FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`03_terminals_employees` AS te ON te.ecid=c.id WHERE c.`id` = '$ecid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$data['employee'] = $sth->fetch();
}
$data['page']="Daily Sales Report";

$this->view->render($data,'pos/dsr');

}	/* fxn */


public function dcr(){	/* daily collection summary */
$dbo=PDBO;
require_once(SITE."functions/posr.php");
$prid = $_SESSION['user']['privilege_id'];
$home=$_SESSION['home'];
if($prid!=0){ flashRedirect($home,'For admin only.'); }
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['today'] = $today = $_SESSION['today'];

if(isset($_GET['filter'])){
	$start=$_GET['start'];
	$end=$_GET['end'];
	$url="pos/dcr?start=$start&end=$end";
	redirect($url);
	exit;
}	/* get */


/* params = trml,date,ecid */
$data['terminal'] = $terminal = isset($_GET['terminal'])? $_GET['terminal']:1;
$data['start'] = $start = isset($_GET['start'])? $_GET['start']:$today;
$data['end'] = $end = isset($_GET['end'])? $_GET['end']:$today;

$where=" WHERE `role_id`='".RINVIS."' AND `privilege_id` <> '0'  ";
// $data['cashiers'] = $cashiers = fetchRows($db,"{$dbo}.`00_contacts`",'id,code,name','name',$where);

$q = "SELECT et.*,c.name AS employee,et.id AS pkid,c.id AS id,c.code,c.name FROM {$dbo}.`03_terminals_employees` AS et
		LEFT JOIN {$dbo}.`00_contacts` AS c ON et.ecid = c.id $where;";
debug($q);
$sth=$db->querysoc($q);
$data['cashiers']=$cashiers=$sth->fetchAll();
$data['count'] = $count= count($cashiers);
$ornos=array();
for($i=0;$i<$count;$i++){
	$ecid=$cashiers[$i]['id'];
	$ornos[$i] = getEmployeeOrnos($db,$ecid,$start,$end); 
	$sales[$i] = getEmployeeSales($db,$ecid,$start,$end); 
}
$data['ornos'] = $ornos;
$data['sales'] = $sales;

$this->view->render($data,'pos/dcr');


}	/* fxn */


public function orlist(){
$dbo=PDBO;
require_once(SITE."functions/pos.php");
require_once(SITE."functions/posr.php");
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$data['srid'] = $srid = $_SESSION['srid'];
$data['prid'] = $prid = $_SESSION['user']['privilege_id'];
$data['admin'] = $admin = ($prid==0)? true:false;
$data['today'] = $today = $_SESSION['today'];
$data['t'] = myTerminal($db);

if(isset($_GET['submit'])){
	$terminal=$_GET['terminal'];
	$start=$_GET['start'];
	$ecid=$_GET['ecid'];
	$end=$_GET['end'];
	$cond="";	
	if(!empty($terminal)){ $cond.="AND p.terminal='$terminal' "; }
	if(!empty($ecid)){ $cond.="AND p.ecid='$ecid' "; }
	$cond.=" AND DATE(p.datetime)>='$start' AND DATE(p.datetime)<='$end' ";	
	$q = " SELECT p.*,p.id AS pos_id,c.name AS customer,e.name AS employee 
	FROM {$dbo}.`30_pos` AS p 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid=c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid=e.id
	WHERE 1=1 $cond ORDER BY p.datetime DESC; ";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll();
	$data['rows'] = $rows;
	$data['count'] = count($rows);
	
}	/* get */


if($admin){
	$where=" WHERE `role_id`='".RINVIS."' ";
	$data['cashiers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,name','name',$where);
}



$this->view->render($data,'pos/orlist');



}	/* fxn */


public function returns($params=NULL){
$dbg=PDBG;$dbo=PDBO;$db=&$this->model->db;
$data['today']=$today=$_SESSION['today'];
$data['start']=$start=isset($params[0])? $params[0]:$today;
$data['end']=$end=isset($params[1])? $params[1]:$today;
$cond="";
$spid=$_SESSION['user']['privilege_id'];
$ecid=$_SESSION['user']['ucid'];
$admin=($spid==0)? true:false;

if(!$admin){ $cond.=" AND p.ecid='$ecid' "; }

$q="
	SELECT
		p.*,pd.*,pr.name AS product,c.name AS customer,e.code AS employee
	FROM {$dbo}.`30_pos` AS p 
		INNER JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id=p.id
		LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id=pr.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid=c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid=e.id
	WHERE 	DATE(p.datetime)>='$start'
		AND DATE(p.datetime)<='$end'
		AND pd.qty<0 $cond;
";
// pr($q);
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);
$this->view->render($data,'pos/returns');


}	/* fxn */


public function rxrpt($params=NULL){
$dbg=PDBG;$dbo=PDBO;$db=&$this->model->db;
$data['today']=$today=$_SESSION['today'];
$data['start']=$start=isset($params[0])? $params[0]:$today;
$data['end']=$end=isset($params[1])? $params[1]:$today;
$cond="";
$spid=$_SESSION['user']['privilege_id'];
$ecid=$_SESSION['user']['ucid'];
$admin=($spid==0)? true:false;

if(!$admin){ $cond.=" AND p.ecid='$ecid' "; }

$q="
	SELECT
		p.*,px.*,pr.name AS product,c.name AS customer,e.code AS employee
	FROM {$dbo}.`30_pos`rx AS px 
		LEFT JOIN {$dbo}.`03_products` AS pr ON px.product_id=pr.id
		LEFT JOIN {$dbo}.`30_pos` AS p ON px.posid=p.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid=c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid=e.id
	WHERE 	DATE(px.date)>='$start'
		AND DATE(px.date)<='$end' $cond;
";
// pr($q);n
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);
$this->view->render($data,'pos/rxrpt');




}	/* fxn */


public function mgr($params=NULL){
$dbo=PDBO;
$data['today']=$_SESSION['today'];
if(isset($_GET['filter'])){
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['cashier'])){ $cond .= " AND p.ecid = '".$get['cashier']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND DATE(p.datetime) >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND DATE(p.datetime) <= '".$get['datetwo']."'"; }				
	if (!empty($get['total'])){ $cond .= " AND p.total >= '".$get['total']."'"; }				
	
	$limits = $get['limits'];
	$offset = ($get['page']-1)*$limits;
	$sort   = (isset($get['sort']))?$get['sort']:'p.date';
	$order  = (isset($get['order']))?$get['order']:'DESC';
 			
	$data['sy']=$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	$q = "
		SELECT
			p.*,p.id AS posid,c.name AS cashier
		FROM {$dbo}.`30_pos` AS p
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ecid = c.id ";	
		$q .= " WHERE 	1=1 $cond  ORDER BY $sort $order LIMIT $limits OFFSET $offset ; ";
	// pr($q);
			
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RINVIS."'";
	$data['cashiers'] = $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			

}	

$this->view->render($data,'pos/mgr');





}	/* fxn */


public function finder(){

if(isset($_GET['filter'])){
	$get=$_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['prid'])){ $cond .= " AND pd.product_id = '".$get['prid']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND DATE(p.datetime) >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND DATE(p.datetime) <= '".$get['datetwo']."'"; }				
	$sort   = (isset($get['sort']))?$get['sort']:'p.date';
	$order  = (isset($get['order']))?$get['order']:'DESC';
	$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;

	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['sy']=$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	
	/* 1 */
	$q="SELECT * FROM {$dbo}.`03_products` WHERE id='".$get['prid']."' LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['product']=$product=$sth->fetch();
	/* 2 */
	$q = "
		SELECT
			pd.*,p.id AS posid,p.datetime,c.name AS cashier
		FROM {$dbo}.`30_positems` AS pd
			INNER JOIN {$dbo}.`30_pos` AS p ON pd.pos_id = p.id 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ecid = c.id 
		";	
		$q .= " WHERE 	1=1 $cond  ORDER BY $sort $order; ";
	debug($q,"posCtlr: finder");			
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	

}	/* get */

$data['today']=$_SESSION['today'];
$vfile="pos/finderPos";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */
	

	
public function rxsummary($params=NULL){
$dbg=PDBG;$dbo=PDBO;
$db=&$this->model->db;
$data['today']=$today=$_SESSION['today'];
$data['start']=$start=isset($params[0])? $params[0]:$today;
$data['end']=$end=isset($params[1])? $params[1]:$today;
$cond="";
$spid=$_SESSION['user']['privilege_id'];
$ecid=$_SESSION['user']['ucid'];
$admin=($spid==0)? true:false;

if(!$admin){ $cond.=" AND p.ecid='$ecid' "; }

$q="
	SELECT
		p.*,pd.*,pr.name AS product,c.name AS customer,e.code AS employee
	FROM {$dbo}.`30_pos` AS p 
		INNER JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id=p.id
		LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id=pr.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid=c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid=e.id
	WHERE 	DATE(p.datetime)>='$start'
		AND DATE(p.datetime)<='$end'
		AND pd.qty<0 $cond ;
";

// pr($q);
$data['q']=$q;
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=$count=count($rows);

// pr($pos);
$pos=array();
for($i=0;$i<$count;$i++){
	$q="SELECT pd.*,pr.name AS product 
	FROM {$dbo}.`30_positems` AS pd 
	INNER JOIN {$dbo}.`03_products` AS pr ON pr.id=pd.product_id 
	WHERE pd.pos_id='".$rows[$i]['rxref_posid']."'; ";
	$sth=$db->querysoc($q);
	$pos[$i]=$sth->fetchAll();
}
$data['pos']=$pos;
$this->view->render($data,'pos/rxsummary');


}	/* fxn */


public function deltxns($params=NULL){
$dbo=PDBO;
$date=isset($params[0])? $params[0]:$_SESSION['today'];
$dbg=PDBG;
$q="
	DELETE 
		p.*,pd.*
	FROM {$dbo}.`30_pos` AS p 
	INNER JOIN {$dbo}.`30_positems` AS pd ON pd.pos_id=p.id
	WHERE DATE(p.datetime)='$date';
";
pr($q);

}	/* fxn */



public function view($params){
$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	$db =& $this->model->db;
	if(empty($params)){ flashRedirect('npos','No pos id.'); } 

	$pos_id = $params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data = viewPos($pos_id,$db,$dbg);
	$data['has_rxref']=($data['pos']['rxref_posid']>0)? true:false;
	if($data['has_rxref']){ 
		$rxref=getPosdetails($db,$data['pos']['rxref_posid']); 
		$data['rxref']['pos']=$rxref['pos'];
		$data['rxref']['positems']=$rxref['positems'];
	}
	
	$data['has_rx']=($data['pos']['rxid']>0)? true:false;
	if($data['has_rx']){
		$rx=getPosdetails($db,$data['pos']['rxid']); 
		$data['rx']['pos']=$rx['pos'];
		$data['rx']['positems']=$rx['positems'];		
	} 
		
	$key = 'pos';
	$data['pos_id']=$pos_id;$data['sy']=$sy;

	$this->view->render($data,'pos/printPos','blank');

}	/* fxn */



public function purge($params=NULL){
$dbo=PDBO;
	echo "tmp dangerous";
	$date=isset($params[0])? $params[0]:$_SESSION['today'];
	$db=&$this->model->db;
	$dbg=PDBG;
	
	$q="
		DELETE a,b FROM {$dbo}.`30_pos` AS a
		INNER JOIN {$dbo}.`30_positems` AS b ON b.pos_id=a.id
		WHERE DATE(a.datetime)='$date';
	";
	debug($q);
	

}	/* fxn */





}	/* PosController */
