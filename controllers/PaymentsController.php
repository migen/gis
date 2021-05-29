<?php

Class PaymentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	


	// $acl = array(array(RAXIS,0),array(RMIS,0),array(4,0));
	// $this->permit($acl,$strict=false);			

	
}


public function beforeFilter(){}	/* fxn */


public function index(){ 
	echo "<h3>Payments</h3>";
	
}	/* fxn */






/* gisv3 */
public function addv3(){
require_once(SITE."functions/pos.php");
require_once(SITE."functions/orno.php");
$db=&$this->model->db;
$dbg=PDBG;
$trml = myTerminal($db);
$trml=isset($_GET['terminal'])? $_GET['terminal']:$trml;
$data['t'] = $t = $trml;

if(isset($_POST['submit'])){
	pr($_POST);
	exit;
	
}	/* post */

$data['last_orno'] = lastOrno($db,$_SESSION['pcid'],$dbg);
$data['payortypes']=fetchRows($db,"{$dbg}.`tpayortypes`","id,name","id");
$this->view->render($data,'payments/add');

}	/* fxn */





/* gisv3 */
public function mgr($params=NULL){
	
$acl = array(array(RAXIS,0),array(RMIS,0),array(4,0));
$this->permit($acl,$strict=false);			
	
$data['today']=$today=$_SESSION['today'];
$data['start']=$start=isset($params[0])? $params[0]:$today;
$data['end']=$end=isset($params[1])? $params[1]:$start;

if(!isset($params[0])){ $url="payments/mgr/$start/$end"; redirect($url); }

require_once(SITE."functions/nextsy.php");
require_once(SITE."functions/payments.php");
$db=&$this->model->db;$dbo=PDBO;
$data['sy']=$sy=DBYR;
$dbg=VCPREFIX.$sy.US.DBG;
$nsy=$sy+1;
$ndbg=VCPREFIX.$nsy.US.DBG;

$tr=array(
	array('vsy'=>$sy,'pdbg'=>$dbg,'pdbg'=>$dbg,'ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
);

$has_ndbg=dbgExists($db,$nsy);
if($has_ndbg){
	$tr1=array(
		array('vsy'=>$nsy,'pdbg'=>$ndbg,'ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
	);		
} else {
	$tr1=array();
}

$tr=array_merge($tr,$tr1);

$i=1;
foreach($tr AS $row){
	$where=" WHERE p.date>='$start' AND p.date <='$end'";
	$q=paymentsRows($db,$row,$where);
	debug($q);
	$sth = $db->querysoc($q);
	${'t'.$i} = $sth->fetchAll();	
	$i++;
}	/* fxn */


if($has_ndbg){
	$rows=array_merge($t1,$t2,$t3,$t4);
} else {
	$rows=array_merge($t1,$t2);
}

$data['rows'] = $rows; 
$data['count']=count($rows);

$this->view->render($data,'payments/mgrPayments');

}	/* fxn */





public function weekly(){
	$acl = array(array(RAXIS,0),array(RMIS,0),array(4,0));
	$this->permit($acl,$strict=false);			
	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$data['action']="weekly";	
	$week_previous=strtotime("-1 week +1 day");
	$week_start=strtotime("this sunday midnight",$week_previous);
	$week_end=strtotime("this saturday",$week_start);

	$data['start']=$start=date("Y-m-d",$week_start);
	$data['end']=$end=date("Y-m-d",$week_end);
	$data['period']=" Week: ".$start." - ".$end;

	$data1=$this->getPayments($db,$data);
	$data=array_merge($data,$data1);

	$this->view->render($data,"payments/weeklyPayments");	
		
}	/* fxn */


public function today(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$data['period']="Today";	
	$data['action']="today";
	$data['start']=$start=$_SESSION['today'];
	$data['end']=$end=$_SESSION['today'];
	
	$data1=$this->getPayments($db,$data);
	$data=array_merge($data,$data1);

	$this->view->render($data,"payments/weeklyPayments");	
		
}	/* fxn */



public function getPayments($db,$var){
	$sy=$var['sy'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$start=$var['start'];
	$end=$var['end'];

	$q="SELECT cr.name AS classroom,
			c.code AS studcode,c.name AS studname,summ.scid,
			sum(p.amount) AS sum_amount,p.date
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.30_payments AS p ON p.scid=c.id
		WHERE p.date>='$start' AND p.date<='$end'
		GROUP BY p.scid
		ORDER BY cr.level_id,cr.section_id,c.is_male,c.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
	
	
}	/* fxn */


public function addxxx(){	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		pr($post);
		exit;
	}	/* post */
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"payments/addPayment");
}	/* fxn */


public function edit($params=NULL){	
	if(!isset($params)){ pr("Param payment_id required."); exit; }

	$acl = array(array(RAXIS,0),array(RMIS,0),array(RMIS,1),array(4,0));
	$this->permit($acl,$strict=true);			
	
	$data['pkid']=$pkid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbtable="{$dbo}.30_payments";
	
	/* this getData stays here for logs details */
	$q="SELECT p.*,p.id AS pkid,c.code AS studcode,c.name AS studname,e.name AS emplname,f.name AS feetype,
			p.sy AS sy
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbo}.30_payments AS p ON p.scid=c.id
		LEFT JOIN {$dbo}.03_feetypes AS f ON p.feetype_id=f.id
		LEFT JOIN {$dbo}.00_contacts AS e ON p.ecid=e.id
		WHERE p.id=$pkid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();	
	extract($row);
	/* post */
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$post['amount']=str_replace(",","",$post['amount']);
		// prx($post);
		$db->update($dbtable,$post,"id=$pkid");
		/* log */
		require_once(SITE.'functions/logs.php');
		$studname=$row['studname'];
		if($row['amount']!=$post['amount']){
			$sydetails = ($row['sy']!=DBYR)? " for SY".$row['sy']:NULL;
			$logdetails="{$studname} - payment edit from ".$row['amount']." to ".$post['amount']." for {$feetype}{$sydetails}.";
			textlog($db,$module_id=2,$logdetails,$row['sy']);	
		}
		
		flashRedirect("payments/edit/$pkid","Saved.");
		exit;
	}	/* post */
	
	$data['paytypes']=$_SESSION['paytypes'];
	$data['feetypes']=$_SESSION['feetypes'];
	$this->view->render($data,"payments/editPayment");
}	/* fxn */



public function report($params=NULL){

	$acl = array(array(RAXIS,0),array(RMIS,0),array(4,0));
	$this->permit($acl,$strict=false);			

	$db=&$this->model->db;$dbo=PDBO;
	// $data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$data['sy']=$sy=(isset($_GET['sy']) && !empty($_GET['sy']))? $_GET['sy']:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;

	if(isset($_GET['filter'])){
		require_once(SITE."functions/payments.php");
		$params = $_GET;	
		$sort = $params['sort'];
		$order = $params['order'];
		$page = $params['page'];
		$limits = $params['limits'];	
		$offset = ($page-1)*$limits;
		$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
						
		$cond = NULL;
		$cond .= "";
		if (!empty($params['sy'])){ $cond .= " AND p.sy = '".$params['sy']."'"; }				
		if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
		if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }				
		if (!empty($params['lvlbeg'])){ $cond .= " AND cr.level_id >= '".$params['lvlbeg']."' "; }				
		if (!empty($params['lvlend'])){ $cond .= " AND cr.level_id <= '".$params['lvlend']."' "; }						
		if (!empty($params['lvlid'])){ $cond .= " AND cr.level_id = '".$params['lvlid']."'"; }					
		if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }						
		if (!empty($params['scid'])){ $cond .= " AND p.scid = '".$params['scid']."'"; }					
		if (!empty($params['ecid'])){ $cond .= " AND p.ecid = '".$params['ecid']."'"; }				
		
		if (!empty($params['feetype_id'])){ $cond .= " AND p.feetype_id = '".$params['feetype_id']."'"; }				
		if (!empty($params['paytype_id'])){ $cond .= " AND p.paytype_id = '".$params['paytype_id']."'"; }				
		$where=" WHERE 1=1 $cond ORDER BY $sort $order $condlimits";	

		$q=" SELECT p.*,p.id AS pkid,sc.code AS studcode,sc.name AS studname,ec.name AS emplname,
				ft.name AS feetype,pt.name AS paytype,cr.name AS classroom,				
				p.amount
			FROM {$dbo}.30_payments AS p 
				LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
				LEFT JOIN {$dbo}.`00_contacts` AS ec ON p.ecid = ec.id
				LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = sc.id
				LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id 
				LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id = ft.id
				LEFT JOIN {$dbo}.03_paytypes AS pt ON p.paytype_id = pt.id
			$where; ";	
		debug($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
	} 	/* filter */

	if(!isset($_SESSION['classrooms'])){ 
		$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 	 } 
	$data['classrooms'] = $_SESSION['classrooms'];	
	$data['levels']=$_SESSION['levels'];	
	
	$data['feetypes']=$_SESSION['feetypes'];
	$data['paytypes']=$_SESSION['paytypes'];

	$data['employees']=fetchRows($db,"{$dbo}.00_contacts","id,name","name"," WHERE role_id=2 ");
	
	$vfile="payments/reportPayments";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */




public function setup($params=NULL){	// with sync
	$acl = array(array(RAXIS,0),array(RMIS,0),array(4,0));
	$this->permit($acl,$strict=true);			

	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$data['dbtable']=$dbtable="{$dbo}.30_payments";

	/* 1 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;
	$except=isset($_GET['except'])? $_GET['except']:"'id'";

	$dr=getDbtableColumnsByArray($db,$schema,$table,$except);
	$data['columns']=$columns=$dr['field_array'];		
	$data['columns']=$columns=array(
		'sy','scid','feetype_id','amount','orno','date',
	);
	$data['num_columns']=count($columns);		
	
	/* 3c */
	$data['last_id']=lastId($db,$dbtable);

	/* 2 */
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		
		$q="INSERT INTO {$dbtable} (sy,scid,feetype_id,amount,date,orno) VALUES ";
		foreach($posts AS $post){
			if(!empty($post['sy'])){
				extract($post);
				$q1="SELECT id FROM {$dbtable} WHERE sy=$sy AND scid=$scid AND feetype_id=$feetype_id LIMIT 1; ";
				$sth=$db->query($q1);
				$row=$sth->fetch();
				if(empty($row)){
					$q.="($sy,$scid,$feetype_id,$amount,'$date','$orno'),";
				}					
				
			}	/* !empty */
		}
		$q=rtrim($q,",");$q.=";";
		pr($q);
		$sth=$db->querysoc($q);
		echo ($sth)? "success":"fail";		
		exit;
	}	/* post */

	
	$vfile="payments/setupPayments";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */





/* gisv5-20200621 */
public function delete($params=NULL){
	require_once(SITE.'functions/logs.php');
	$acl=array(array(2,0),array(5,0));
	$this->permit($acl,false);		

	if(!isset($params[0])){ pr("Parameters pkid required."); exit; }
	$pkid=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;	
	$dbtable="{$dbo}.30_payments";	
	
	$q="SELECT p.*,c.name AS studname,f.name AS feetype 
		FROM {$dbtable} AS p 
		LEFT JOIN {$dbo}.00_contacts AS c ON c.id=p.scid 
		LEFT JOIN {$dbo}.03_feetypes AS f ON f.id=p.feetype_id 
		WHERE p.id=$pkid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	extract($row);

	/* process */
	$db->delete($pkid,$dbtable);
	
	/* log */
	$ecid=$_SESSION['ucid'];
	$sy=$row['sy'];
	$sydetails = ($row['sy']!=DBYR)? " for SY".$row['sy']:NULL;
	$details="{$studname} - payment delete of P{$amount} for {$feetype}{$sydetails}.";
	textlog($db,$module_id=2,$details,$sy);
	
	// $url=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.$_SESSION['home'];
	// redirectUrl($url,"updated.");
	$url="enrollment/ledger/$scid/$sy";
	flashRedirect($url,"Payment deleted.");
	
	
}	/* fxn */






}	/* BlankController */
