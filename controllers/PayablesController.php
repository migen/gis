<?php

Class PayablesController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	pr("Payables");
	
}


/* gisv5-20200619 */
public function add($params=NULL){
	$acl = array(array(5,0),array(2,0));
	$this->permit($acl);			
	require_once(SITE.'functions/dbtools.php');
	$scid=$params[0];
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$dbtable="{$dbo}.30_payables";
	$data['feetype_id']=$feetype_id=isset($_GET['feetype_id'])? $_GET['feetype_id']:false;
	if($feetype_id){ 
		$r=fetchRow($db,"{$dbo}.03_feetypes",$feetype_id,"name AS feetype");
		$data['feetype']=$r['feetype']; 
	}
	// if(!isset($params[0])){ pr("Parameters scid and sy required."); exit; }
if($scid){

	/* post */
	if(isset($_POST['submit'])){
		require_once(SITE.'functions/logs.php');
		$post=$_POST['post'];
		$db->add($dbtable,$post);		
		/* log */
		// $details=$_POST['studname']." - ".$_POST['amount']." to ".$post['amount']." - payable edited.";
		// ezlog($db,$details,$sy);		

		$loggee=$_POST['studname'];
		$details="$loggee - add payable ".$post['amount'];
		textlog($db,$module_id=2,$details,$sy);


		$url=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.$_SESSION['home'];
		redirectUrl($url,"Updated.");
		exit;
		
	}	/* post */

	/* process */
	// $dr=getDbtableColumnsByArray($db,$dbo,"30_payables",$except="'id','sy','','feetype_id'");
	// $data['cols']=$dr['field_array'];		
	// $data['cols_count']=$dr['count'];			
	// $data['payables_string']=$dr['field_string'];			

	// $data['cols']=array('');			
	// $data['cols_count']=$dr['count'];			
	// $data['payables_string']=$dr['field_string'];			

	
	$q="SELECT c.name AS studname,c.code AS studcode
		FROM {$dbo}.00_contacts AS c 
		WHERE c.id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);	
	$data['row']=$sth->fetch();

	$data['readonly']=array('scid','id');	
	
}	/* scid */

		
	
	$data['feetypes']=$_SESSION['feetypes'];	
	$this->view->render($data,"payables/addPayable");
	
	
}	/* fxn */



/* gisv5-20200608 */
public function edit($params=NULL){
	$acl = array(array(2,0),array(5,0));
	$this->permit($acl,false);		

	require_once(SITE.'functions/dbtools.php');
	if(!isset($params[0])){ pr("Parameters scid and sy required."); exit; }
	$id=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$dbtable="{$dbo}.30_payables";

	/* post */
	if(isset($_POST['submit'])){
		// prx($_POST);
		require_once(SITE.'functions/logs.php');
		$post=$_POST['post'];$scid=$_POST['scid'];
		$db->update($dbtable,$post,"id=$id");		
		/* log */
		if($_POST['amount']!=$post['amount']){
			$details=$_POST['studname']." - payable edit from ".$_POST['amount']." to ".$post['amount']." for ".$_POST['feetype'].".";
			textlog($db,$module_id=2,$details,$post['sy']);
		}
		
		$url=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.$_SESSION['home'];
		redirectUrl($url,"Updated.");
		exit;
		
	}	/* post */

	/* process */
	// $dr=getDbtableColumnsByArray($db,$dbg,"30_payables",$except="'id','scid'");
	$dr=getDbtableColumnsByArray($db,$dbo,"30_payables",$except="'null'");
	$data['rows']=$dr['field_array'];		
	$data['count']=$dr['count'];			
	$data['payables_string']=$dr['field_string'];			
	// $data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$scid");		

		
	$q="SELECT s.name AS studname,s.code AS studcode,p.*,p.id AS pkid,f.is_discount,f.name AS feetype
		FROM {$dbtable} AS p 
		INNER JOIN {$dbo}.00_contacts AS s ON p.scid=s.id
		LEFT JOIN {$dbo}.03_feetypes AS f ON p.feetype_id=f.id
		WHERE p.id=$id LIMIT 1;";
	$sth=$db->querysoc($q);	
	$data['readonly']=array('scid','id');	
	$data['row']=$sth->fetch();
	
	/* data */
	$data['feetypes']=$_SESSION['feetypes'];
	
	$this->view->render($data,"payables/editPayable");
	
	
}	/* fxn */



public function report($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
// 	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$data['sy']=$sy=(isset($_GET['sy']) && !empty($_GET['sy']))? $_GET['sy']:DBYR;
	
	$dbg=VCPREFIX.$sy.US.DBG;

	if(isset($_GET['filter'])){
		// require_once(SITE."functions/payables.php");
		$params = $_GET;	
		$balance_option = $params['balance_option'];
		$balance = $params['balance'];
		$sort = $params['sort'];
		$order = $params['order'];
		// $page = (isset($params['page']) && $params['page']<1)? $params['page']:1;
		$page = (empty($params['page']))? 1:$params['page'];
		$limits = $params['limits'];	
		$offset = ($page-1)*$limits;
		$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
						
		$cond = NULL;
		$cond .= "";
		if (!empty($params['sy'])){ $cond .= " AND p.sy = '".$params['sy']."'"; }				
		if (!empty($params['lvlid'])){ $cond .= " AND cr.level_id = '".$params['lvlid']."'"; }					
		if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }		
		if (!empty($params['feetype_id'])){ $cond .= " AND p.feetype_id = '".$params['feetype_id']."'"; }				
		if($balance_option==1){ 
			$cond.=" AND p.balance > $balance AND ft.is_discount<>1 "; 
		}
		
		$where=" WHERE 1=1 $cond ORDER BY $sort $order $condlimits";	
			
		$q=" SELECT p.*,p.id AS pkid,p.amount,c.code AS studcode,c.name AS studname,
				ft.name AS feetype,cr.name AS classroom
			FROM {$dbo}.30_payables AS p 
				LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid = c.id
				LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
				LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id 
				LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id = ft.id
			$where ; ";	
		debug($_REQUEST);
		debug($q);		
		pr($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
	} 	/* filter */

	if(!isset($_SESSION['classrooms'])){ 
		$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 	 } 
	$data['classrooms'] = $_SESSION['classrooms'];	
	$data['levels']=$_SESSION['levels'];	
	$data['feetypes']=$_SESSION['feetypes'];	
	
	
	$vfile="payables/reportPayables";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */





public function batch($params=NULL){	/* setupAddons */
require_once(SITE."functions/setup.php");
$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","id,is_discount,name,amount","name");
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id");
$data['today'] = $today = $_SESSION['today'];

if(isset($_POST['delete'])){
	$fee=$_POST['fee'];
	extract($fee);
	$dbg=VCPREFIX.$sy.US.DBG;
	$cond=($lvl>0)? "cr.level_id=$lvl":false; 
	$cond=($crid>0)? "cr.id=$crid":$cond; 
	
	$q="DELETE p FROM {$dbo}.30_payables AS p 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE $cond AND p.sy=$sy AND p.feetype_id=$feetype_id AND p.ptr=$ptr; ";	
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "success":"fail";echo "<br />";
	echo "<a href='".URL."/payables/batch'>Payables Batch</a>";
	exit;	
	

}	/* delete */


if(isset($_POST['submit'])){
$post=$_POST['fee'];
extract($post);
// pr($post);
$feetype_id=($feetype_id>0)? $feetype_id:false;
$today=$_SESSION['today'];
$due_on=isset($due_on)? $due_on:$today; 

if($feetype_id && $amount){	
	$cond=($lvl>0)? "cr.level_id=$lvl":false; 
	$cond=($crid>0)? "cr.id=$crid":$cond; 
	$q="SELECT p.id,p.scid AS pscid,summ.scid AS summscid,p.feetype_id
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id		
		LEFT JOIN {$dbo}.30_payables AS p ON (p.sy=$sy AND p.scid=summ.scid AND p.feetype_id=$feetype_id
			AND p.feetype_id=$feetype_id)
		WHERE $cond 
		ORDER BY summ.scid; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();	
	$q="INSERT INTO {$dbo}.30_payables(sy,scid,feetype_id,amount,ptr,due_on,in_tuition)VALUES";	
	foreach($rows AS $row){
		if(empty($row['pscid'])){
			$q.="($sy,".$row['summscid'].",$feetype_id,'$amount',$ptr,'$due_on',$in_tuition),";			
		}
		
	}				
	$q=rtrim($q,",");
	$q.=";";
}

// prx($q);
$sth=$db->query($q);
echo ($sth)? "success":"fail";echo "<br />";
echo "<a href='".URL."/payables/batch'>Payables Batch Add</a>";
exit;	

}	/* post */


$vfile="payables/batchPayables";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */





public function setup($params=NULL){	// with sync
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$data['dbtable']=$dbtable="{$dbo}.30_payables";

	/* 1 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;
	$except=isset($_GET['except'])? $_GET['except']:"'id'";

	$dr=getDbtableColumnsByArray($db,$schema,$table,$except);
	$data['columns']=$columns=$dr['field_array'];		
	$data['columns']=$columns=array(
		'sy','scid','feetype_id','amount','due_on',
	);
	$data['num_columns']=count($columns);		
	
	/* 3c */
	$data['last_id']=lastId($db,$dbtable);

	/* 2 */
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];		
		$q="INSERT INTO {$dbtable} (sy,scid,feetype_id,amount,due_on) VALUES ";
		foreach($posts AS $post){
			if(!empty($post['sy'])){			
				extract($post);
				$q1="SELECT id FROM {$dbtable} WHERE sy=$sy AND scid=$scid AND feetype_id=$feetype_id LIMIT 1; ";
				$sth=$db->query($q1);
				$row=$sth->fetch();
				if(!$row){
					$q.="($sy,$scid,$feetype_id,$amount,'$due_on'),";
				}
			}
		}
		$q=rtrim($q,",");$q.=";";
		pr($q);
		$sth=$db->querysoc($q);
		echo ($sth)? "success":"fail";		
		exit;	
	}	/* post */

	
	$vfile="payables/setupPayables";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */



/* gisv5-20200621 */
public function delete($params=NULL){
	require_once(SITE.'functions/logs.php');
	$acl=array(array(2,0),array(5,0));
	$this->permit($acl,false);		

	if(!isset($params[0])){ pr("Parameters pkid required."); exit; }
	$pkid=$params[0];
	$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;	
	$dbtable="{$dbo}.30_payables";	
	
	$q="SELECT p.*,c.name AS studname,f.name AS feetype FROM {$dbo}.30_payables AS p 
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
	$details="{$studname} - payable delete of P{$amount} for {$feetype}{$sydetails}.";
	textlog($db,$module_id=2,$details,$sy);
	
	// $url=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.$_SESSION['home'];
	// redirectUrl($url,"updated.");
	$url="enrollment/ledger/$scid/$sy";
	flashRedirect($url,"Payable deleted.");
	
	
}	/* fxn */





}	/* PayablesController */
