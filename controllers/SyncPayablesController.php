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
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;


    
	require_once(SITE."functions/reflections.php");
    $data['class']=$class=get_called_class();	
	$data=reflectMethods($class);
    $data['rows']=&$data['methods'];		
	$vfile="controllers/methodsControllers";vfile($vfile);
	$class_name=$data['class'];$controller_name=str_replace("Controller","",$class_name);$controller_name=strtolower($controller_name);
	$data['controller_name']=$controller_name;
    

    // pr($data);
    // exit;
	
	$this->view->render($data,"syncpayables/indexSyncpayablesReflection");

}	/* fxn */




public function indexOK($params=NULL){	
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


/* 
* 1 - copy to nextSY payables with passed parent_id of feetype 
* params(feeparent_id/sy_from/$sy_to)

*/
public function copyToNextsyByFeeParent($params=NULL){
	$feeparent_id=$params[0];
	$sy_from=$params[1];
	$sy_to=$params[2];
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	
	pr('params - feeparent_id/sy_from/sy_to');
	pr('&page=1 - break into chunks');
	
	$page = (isset($_GET['page']))? $_GET['page']:1;
	$limit = (isset($_GET['limit']))? $_GET['limit']:1000;
	$offset = ($page-1)*$limit;
	$last_index=$limit-1;
	
	
	// $scid=3115;
	$q="
		SELECT 
			p.*,p.id AS payable_id
		FROM {$dbo}.30_payables AS p 
		INNER JOIN {$dbo}.03_feetypes AS ft ON ft.id=p.feetype_id
		INNER JOIN {$dbo}.03_feetypes AS fp ON fp.id=ft.parent_id
		WHERE sy=$sy_from AND fp.id=$feeparent_id LIMIT $limit OFFSET $offset;			
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();

	// pr($data);

	pr('Last record of this page.');
	pr($rows[$last_index]);
	foreach($rows AS $i => $row){
		extract($row);
		$q="SELECT id FROM {$dbo}.30_payables WHERE sy=$sy_to AND scid=$scid AND feetype_id=$feetype_id AND ptr=$ptr LIMIT 1; ";
		$sth=$db->querysoc($q);
		$found=$sth->fetch();
		if(!$found){
			$q="INSERT INTO {$dbo}.30_payables(sy,scid,feetype_id,amount,ptr)VALUES";		
			$q.="($sy_to,$scid,$feetype_id,'$amount',$ptr);";
			$db->query($q);			
		}
	}
	echo "<hr>";
	pr($q); 
	$did_insert=(substr($q,0,6)=="SELECT")? false:true;
	
	pr(substr($q,0,6));
	echo ($did_insert)? "DID INSERT":"NOTHING TO INSERT";
	
	
}	/* fxn */


public function updatePercentAmount($params=NULL){
// public function abc($params=NULL){
	$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$sy_enrollment=$sy;
	$dbo=PDBO;
	$db=&$this->baseModel->db;
	$dbg=VCPREFIX.$sy.US.DBG;

	pr("params[0] sy_enrollment - $sy_enrollment");
	pr('&page=1 - break into chunks');
	echo '<hr>';
	
	$page = (isset($_GET['page']))? $_GET['page']:1;
	$limit = (isset($_GET['limit']))? $_GET['limit']:10;
	$offset = ($page-1)*$limit;
	$last_index=$limit-1;


	$q="SELECT p.id AS pkid,p.scid,p.amount,p.feetype_id,ft.percent
		FROM {$dbo}.30_payables AS p 
		INNER JOIN {$dbo}.03_feetypes AS ft ON ft.id=p.feetype_id
		WHERE p.sy=$sy AND ft.is_percent=1 LIMIT $limit OFFSET $offset; ";
	$sth=$db->querysoc($q);
	$payables=$sth->fetchAll();
	pr($q);
	echo '<hr>';

	foreach($payables AS $i => $payable){
		$scid=$payable['scid'];
		$q="SELECT d.amount AS tuition_amount
			FROM {$dbg}.05_summaries AS summ
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.`03_tfeedetails` AS d ON (d.sy=$sy AND d.level_id=cr.level_id AND d.num=cr.num AND d.feetype_id=1)
			WHERE summ.scid=$scid; ";	
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$payables[$i]=array_merge($payables[$i],$row);
		
		
	}	/* foreach1 */
	pr($q);
	pr($payables[$last_index]);

	
	foreach($payables AS $i => $payable){
		extract($payable);
		$derived=round(($percent*$tuition_amount/100),2);
		$amount=round($amount,2);
		if($amount!=$derived){
			$q="UPDATE {$dbo}.30_payables SET amount='$derived' WHERE id=$pkid LIMIT 1; ";
			pr($q);
			$db->query($q);
			
		} 

	}	/* foreach2 */
	
}	/* fxn */


/* query 
SELECT c.name,ft.name AS feetype,p.*,cr.id AS crid,cr.level_id
			FROM dbone_sjam.30_payables AS p 
			INNER JOIN dbone_sjam.00_contacts AS c ON p.scid=c.id
			LEFT JOIN dbone_sjam.03_feetypes AS ft ON ft.id=p.feetype_id
			INNER JOIN 2021_dbgis_sjam.05_summaries AS summ ON summ.scid=p.scid
			INNER JOIN 2021_dbgis_sjam.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.sy=2021 AND cr.level_id=14 AND p.feetype_id=51;

	SET p.{$field}='".${$value}."'
			
*/
public function batchUpdate1($params=NULL){
	$data['field']=$field=isset($_GET['field'])? $_GET['field']:'amount';
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		extract($post);			
		$cond=NULL;
		if(!empty($field2)){ $cond = " ,p.{$field2}='$value2'";  }
		
		$q="UPDATE {$dbo}.30_payables AS p 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.scid
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			SET p.{$field}='".$value."' $cond
			WHERE p.sy=$sy AND cr.level_id=$level_id AND p.feetype_id=$feetype_id;";				
		// prx($q);
		$sth=$db->query($q);
		$msg = ($sth)? "Success":"Fail";		
		$url="syncPayables/batchUpdate";
		flashRedirect($url,$msg);
		
		// pr('<a herf="'.URL.'/syncpayables/batchUpdate" >Batch Update Payables another</a>');
		
	}
	
	
	if(isset($_POST['view'])){
		$post=$_POST['post'];
		extract($post);				

		$q="SELECT c.name AS student,ft.name AS feetype,p.*,cr.id AS crid,cr.level_id,p.ptr
			FROM dbone_sjam.30_payables AS p 
			INNER JOIN dbone_sjam.00_contacts AS c ON p.scid=c.id
			LEFT JOIN dbone_sjam.03_feetypes AS ft ON ft.id=p.feetype_id
			INNER JOIN 2021_dbgis_sjam.05_summaries AS summ ON summ.scid=p.scid
			INNER JOIN 2021_dbgis_sjam.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.sy=$sy AND cr.level_id=$level_id AND p.feetype_id=$feetype_id; ";		
		// pr($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
		$this->view->render($data,'syncpayables/viewSyncpayables');
		
	}	/* query */
	
	$data['levels']=$_SESSION['levels'];
	$data['feetypes']=$_SESSION['feetypes'];
	$this->view->render($data,"syncpayables/batchUpdatePayables");
	
}	/* fxn */


public function batchUpdate($params=NULL){
	$data['field']=$field=isset($_GET['field'])? $_GET['field']:'amount';
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		extract($post);			
		$cond=NULL;
		$cond_sel=NULL;
		if(!empty($field2)){ $cond = " ,{$field2}='$value2'";  }
		if(!empty($field2)){ $cond_sel = " AND p.{$field2}<>'$value2'";  }
		
		$q="SELECT p.id AS pkid FROM {$dbo}.30_payables AS p 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.scid
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.sy=$sy AND cr.level_id=$level_id AND p.feetype_id=$feetype_id 
			AND p.{$field}<>'$value' $cond_sel ;";
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		
		
		foreach($rows AS $i => $row){
			$pkid=$row['pkid'];
			$q="UPDATE {$dbo}.30_payables SET {$field}='".$value."' $cond WHERE id=$pkid LIMIT 1; ";
			$db->query($q);

		}
		$url="syncPayables/batchUpdate";
		$msg='loop done';
		flashRedirect($url,$msg);
				
		// pr('<a herf="'.URL.'/syncpayables/batchUpdate" >Batch Update Payables another</a>');
		
	}
	
	
	if(isset($_POST['view'])){
		$post=$_POST['post'];
		extract($post);				

		$q="SELECT p.id AS pkid,c.name AS student,ft.name AS feetype,p.*,cr.id AS crid,cr.level_id,p.ptr
			FROM dbone_sjam.30_payables AS p 
			INNER JOIN dbone_sjam.00_contacts AS c ON p.scid=c.id
			LEFT JOIN dbone_sjam.03_feetypes AS ft ON ft.id=p.feetype_id
			INNER JOIN 2021_dbgis_sjam.05_summaries AS summ ON summ.scid=p.scid
			INNER JOIN 2021_dbgis_sjam.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.sy=$sy AND cr.level_id=$level_id AND p.feetype_id=$feetype_id; ";		
		// pr($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
		$this->view->render($data,'syncpayables/viewSyncpayables');
		
	}	/* query */
	
	$data['levels']=$_SESSION['levels'];
	$data['feetypes']=$_SESSION['feetypes'];
	$this->view->render($data,"syncpayables/batchUpdatePayables");
	
}	/* fxn */






}	/* BlankController */
