<?php

Class BalancesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$acl = array(array(2,0),array(5,0),array(6,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['levels']=$_SESSION['levels'];
	$this->view->render($data,'balances/index'); 
} 

	
	
public function level($params=NULL){
$dbo=PDBO;
$home = $_SESSION['home'];
require_once(SITE."functions/classrooms.php");	
require_once(SITE."functions/fees.php");	
require_once(SITE."functions/logs.php");	


$today = $_SESSION['today'];
$data['get'] = $get = isset($_GET)? $_GET:false;
$data['lvlid'] = $lvlid = isset($params[0])? $params[0]:4;
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$ssy = $_SESSION['sy'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['is_transitioned'] = $is_transitioned = (DBYR==$_SESSION['sy'])? true:false;
$data['ecid'] = $ecid = $_SESSION['pcid'];
$sort=isset($_GET['sort'])? $_GET['sort']:"c.name";
$order=isset($_GET['order'])? $_GET['order']:"ASC";
if(!$is_transitioned) {	$_SESSION['message'] = "SY Not Transitioned Yet!"; }	

$_SESSION['tfeeid'] = isset($_SESSION['tfeeid'])? $_SESSION['tfeeid'] : feecode_id($db,'tfee');
$data['tfeeid'] = $tfeeid = $_SESSION['tfeeid']; 		
$data['cutoff'] = $cutoff  = isset($get['cutoff'])? $get['cutoff'] : $_SESSION['today'];

/* 1 - level tuition */	
$sxn=isset($_GET['sxn'])? $_GET['sxn']:false;
$data['sxn']=&$sxn;

$num=isset($_GET['sxn'])? getNumByLvlSxn($db,$lvlid,$sxn,$dbg):1;
$num=($num==0)? 1:$num;
$data['num']=&$num;


$data1 = levelTuition($db,$lvlid,$num);
$data = array_merge($data,$data1);


/* 2 and 5 */
updateLevelBalances($db,$lvlid,$dbg);

/* 3 records or rows */		
$data2=levelBalances($db,$lvlid,$dbo,$dbg,$sort,$order,$get);

$data = array_merge($data,$data2);
$rows = $data['rows'];

	
/* 4 - sync level tsum and summaries */	
$url="setaxis/initialize/$lvlid";
syncLevelTsumSumm($db,$rows,$url,$dbg);


/* 5 - secrets */	
	$key = 'ledgers';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];


/* 5 payments */
$pays = array();
$paycond=" AND p.date<='$cutoff' AND p.feetype_id='$tfeeid' ";
foreach($rows AS $row){
	$q = "SELECT p.amount,p.orno,p.date,p.pointer,p.scid,p.id AS pid,ft.name AS feetype
			FROM {$dbo}.30_payments AS p LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id			
		WHERE p.`scid` = '".$row['scid']."' $paycond ORDER BY p.date; ";	
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$pays[] = $b;	
}	/* foreach */
$data['pays'] = $pays;


/* 6 auxes */
$auxes = array();
foreach($rows AS $row){
	$q = "SELECT a.amount,ft.name AS feetype 
			FROM {$dbg}.`30_auxes` AS a LEFT JOIN {$dbo}.`03_feetypes` AS ft ON a.feetype_id = ft.id			
		WHERE a.`scid` = '".$row['scid']."' ORDER BY a.id; ";		
	$sth = $db->querysoc($q);
	$c = $sth->fetchAll();
	$auxes[] = $c;	
}	/* foreach */
$data['auxes'] = $auxes;

/* 7 */

$dues=array();


$data['get']['paymode'] = $get['paymode'] = (isset($get['paymode']))? $get['paymode']:false;
if($get['paymode']>0){
	/* 7.1 */
	$paymode=$get['paymode'];
	$tuition=$data['tuition'];	
	$data['paymoderow'] = $paymoderow = fetchRow($db,"{$dbo}.`03_paymodes`",$paymode);	
	
	$data['paydates'] = $paydates = $paymoderow['dates'];	
	$data['assessed'] = $assessed = $tuition['y1_dpfee'];	
	$pmr = switchPaymodes($paymode,$tuition);				
	$data['dpfee'] = $dpfee = $pmr['dpfee'];
	$data['dpdue'] = $dpdue = $pmr['dpdue'];
	$data['annuity'] = $annuity = $pmr['annuity'];
	$data['totalpaymodes'] = $totalpaymodes = getTotalPaymodes($paymode);
	$data['numpaymodes'] = $numpaymodes = getNumPaymodes($paydates,$cutoff);
	
	/* 7.2 */
	for($i=0;$i<$data['count'];$i++){			
		$dues[$i] = getDues($assessed,$dpfee,$annuity,$totalpaymodes,$numpaymodes,$rows[$i]['discounts']);					
	}	/* foreach */
	
}	/* paymode */

$data['dues'] = $dues;
	
	$data['sections'] = getSectionsByLevel($db,$lvlid,$dbg);	
	if(!isset($_SESSION['levels'])){ $_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id"); 	 } 
	$data['levels']=$_SESSION['levels'];	
	if(!isset($_SESSION['paymodes'])){ $_SESSION['paymodes'] = fetchRows($db,"{$dbo}.`03_paymodes`","*","id"); } 
	$data['paymodes'] = $_SESSION['paymodes'];			
	if(!isset($_SESSION['feetypes'])){ $_SESSION['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","id,name","name"); } 
	$data['feetypes'] = $_SESSION['feetypes'];		
	$data['level_id']=$data['lvl']=$lvlid;	
	$this->view->render($data,"balances/levelBalances");


}	/* fxn */


public function tsum($params=NULL){
$dbo=PDBO;
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;

$all=isset($_GET['all'])? true:false;
$cond=($all)? NULL:" AND cr.level_id='$lvl' ";

$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
$db=&$this->model->db;

$q="
SELECT c.name AS student,c.code AS studcode,tsum.balance,cr.name AS classroom,sxn.name AS section
FROM {$dbg}.03_tsummaries AS tsum 
INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=tsum.scid
INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
WHERE 1=1 $cond ORDER BY sxn.name LIMIT 200;
";
// pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id"); 	

$this->view->render($data,'balances/tsum');

}	/* fxn */



public function refresh($params=NULL){
$lvl=isset($params[0])? $params[0]:4;

echo "Lvl: $lvl";


}	/* fxn */


public function enrolled($params=4){
$data['lvl']=$lvl=$params[0];
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$q="SELECT c.id,c.code,c.name,p.scid,p.amount,p.pointer,SUM(p.amount) AS total,c.is_enrolled
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	INNER JOIN {$dbo}.30_payments AS p ON p.scid=c.id
	WHERE cr.level_id='$lvl' AND p.pointer > 0
	GROUP BY p.scid ORDER BY c.name;";

$q="SELECT c.id,c.code,c.name,p.scid,p.amount,p.pointer,SUM(p.amount) AS total,c.is_enrolled
	FROM {$dbo}.`00_contacts` AS c 
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	LEFT JOIN {$dbo}.30_payments AS p ON p.scid=c.id
	WHERE cr.level_id='$lvl' AND c.is_active=1 AND p.pointer > 0 AND cr.section_id<>2
	GROUP BY p.scid ORDER BY c.name;";	
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$data['level']=fetchRecord($db,"{$dbo}.`05_levels`","id='$lvl'");
$this->view->render($data,'balances/enrolledBalances');

}	/* fxn */


public function unenrolled($params=4){
$data['lvl']=$lvl=$params[0];
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$q="SELECT c.id,c.code,c.name,c.is_enrolled,p.scid,p.amount,p.pointer,p.ptr1,summ.crid,cr.level_id AS lvl
	FROM {$dbo}.`00_contacts` AS c 
LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
INNER JOIN (SELECT *,MAX(CASE WHEN pointer='1' THEN amount ELSE NULL END) AS `ptr1` FROM {$dbo}.30_payments GROUP BY scid) AS p ON c.id=p.scid
	WHERE p.ptr1 IS NULL
	GROUP BY p.scid ORDER BY c.name;";
pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$data['level']=fetchRecord($db,"{$dbo}.`05_levels`","id='$lvl'");
$this->view->render($data,'balances/unenrolledBalances'); 

 
/* $q="SELECT a.*,a.name AS student,b.*,b.ptr1
FROM {$dbo}.testcontacts AS a 
INNER JOIN ( SELECT *,MAX(CASE WHEN ptr = '1' THEN amount ELSE NULL END) AS `ptr1` FROM {$dbo}.testenrolled GROUP BY scid) AS b ON a.id=b.scid
WHERE b.ptr1 IS NULL
ORDER BY a.name ";  
pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$data['level']=fetchRecord($db,"{$dbo}.`05_levels`","id='$lvl'");
$this->view->render($data,'balances/testenrolledBalances');  */

 
}	/* fxn */


public function updateEnrolled($params=4){
$lvl=$params[0];
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$q="

UPDATE {$dbo}.`00_contacts` AS a 
	INNER JOIN (
SELECT c.id,c.code,c.name,c.is_enrolled,p.scid,p.amount,p.pointer,p.ptr1,summ.crid,cr.level_id AS lvl
FROM {$dbo}.`00_contacts` AS c 
LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
INNER JOIN (SELECT *,MAX(CASE WHEN pointer='1' THEN amount ELSE NULL END) AS `ptr1` FROM {$dbo}.30_payments GROUP BY scid) AS p ON c.id=p.scid
WHERE p.ptr1 IS NULL
GROUP BY p.scid ORDER BY c.name
) AS b ON a.id=b.scid 
SET a.is_enrolled=0;";

debug($q);
$sth=$db->query($q);
$sth=$db->query($q);
echo ($sth)? "Unenrolled Updated":"Unenrolled Failed";

$q="UPDATE {$dbo}.`00_contacts` AS a 
	INNER JOIN (
		SELECT c.id,c.code,c.name,p.scid,p.pointer,SUM(p.amount) AS total,c.is_enrolled
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.30_payments AS p ON p.scid=c.id
		WHERE p.pointer > 0
		GROUP BY p.scid ORDER BY c.name
	) AS b ON a.id=b.scid 
	SET a.is_enrolled=1;";
// pr($q);
debug($q);
$sth=$db->query($q);
echo "<br />";
echo ($sth)? "Enrolled Updated":"Enrolled Failed";


}	/* fxn */




}	/* BalancesController */
