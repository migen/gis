<?php

Class SyncPayablesController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();

	$acl = array(array(5,0));
	$this->permit($acl,false);		
	
}	/* fxn */





public function index($params=NULL){	
	// pr("Sync Payables");
	$data=NULL;
	$this->view->render($data,"syncpayables/indexSyncpayables");

}	/* fxn */



public function partOneSyncRows(){
require_once(SITE."functions/payablesFxn.php");

pr("<h1>&exe</h1>");
pr("&page &limit &order");

$db=&$this->baseModel->db;
$dbo=PDBO;
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;
	
/* pagination */
$limit=isset($_GET['limit'])? $_GET['limit']:500;
$page=isset($_GET['page'])? $_GET['page']:1;
$offset = ($page-1)*$limit;

$order=isset($_GET['order'])? $_GET['order']:"summ.scid";

$q="SELECT summ.scid,c.name
	FROM {$dbg}.05_summaries AS summ 
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
	WHERE cr.section_id>2 ORDER BY $order LIMIT $limit OFFSET $offset;";
pr($q);
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();


$scid_arr=buildArray($rows,'scid');
$count=count($scid_arr);
pr($count);


// updateTfeePayables($db,$sy,$scid=2233);
// updateTfeePayables($db,$sy,$scid=2234);

if(isset($_GET['exe'])){
	foreach($scid_arr AS $i => $scid){
		print("($i) - Updating - $scid.");
		updateTfeePayables($db,$sy,$scid);
		print(" | Done - $scid.");
		echo '<br />';
	}	
} else {
	if(isset($_GET['scid'])){
		pr($scid_arr);
	}

}

	
	
}	/* fxn */




public function partTwoUpdateAmount($params=NULL){	// part2, part1 is update/syncTfeesPayables
// updatePayablesByClassroom	
require_once(SITE."functions/payablesFxn.php");


pr("<h1>&exe</h1>");
pr("param-0: sy");
pr("&page &limit &order");

$db=&$this->baseModel->db;
$dbo=PDBO;
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;

/* pagination */
$limit=isset($_GET['limit'])? $_GET['limit']:500;
$page=isset($_GET['page'])? $_GET['page']:1;
$offset = ($page-1)*$limit;

$order=isset($_GET['order'])? $_GET['order']:"summ.scid";

$q="SELECT summ.scid,c.name
	FROM {$dbg}.05_summaries AS summ 
	INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
	INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
	WHERE cr.section_id>2 ORDER BY $order LIMIT $limit OFFSET $offset;";
pr($q);
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();


$scid_arr=buildArray($rows,'scid');
$count=count($scid_arr);
pr($count);


if(isset($_GET['exe'])){
	foreach($scid_arr AS $i => $scid){
		print("($i) - Updating - $scid.");
		updatePayableBalanceByScid($db,$sy,$scid);
		print(" | Done - $scid.");
		echo '<br />';
	}	
} else {
	pr($scid_arr);
}

/* exe */





	
}	/* fxn */





}	/* BlankController */
