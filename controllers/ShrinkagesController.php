<?php

Class ShrinkagesController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */




public function filter(){
$dbo=PDBO;

if(isset($_GET['filter'])){
	// pr($_GET);
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['terminal'])){ $cond .= " AND sk.terminal = '".$get['terminal']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND sk.date >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND sk.date <= '".$get['datetwo']."'"; }				
	if (!empty($get['reference'])){ $cond .= " AND sk.reference = '".$get['reference']."'"; }				
	if (!empty($get['remarks'])){ $cond .= " AND sk.remarks LIKE '%".$get['remarks']."%'"; }				
	if (!empty($get['suppid'])){ $cond .= " AND p.suppid = '".$get['suppid']."'"; }				
	
	$limits = $get['limits'];
	$offset = ($get['page']-1)*$limits;
	$sort   = (isset($get['sort']))?$get['sort']:'sk.date';
	$order  = (isset($get['order']))?$get['order']:'DESC';
 			
	$data['sy']=$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	$q = "SELECT sk.*,sk.id AS skid,p.barcode,p.name AS product,p.code AS code,st.name AS sktype
		FROM {$dbg}.`30_shrinkages` AS sk 
			LEFT JOIN {$dbo}.`03_products` AS p ON sk.prid = p.id 
			LEFT JOIN {$dbo}.sktypes AS st ON sk.sktype_id = st.id ";	
		$q .= " WHERE 	1=1 $cond  ORDER BY $sort $order LIMIT $limits OFFSET $offset ; ";
	debug($q);			
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			
}	


/* for batch */
if(isset($_POST['batch'])){
	$ids = isset($_POST['rows'])? $_POST['rows']:null;
	$strids = isset($_POST['rows'])? stringify($ids):null;	
	if(!empty($strids)){$url = 'shrinkages/lote/'.$strids;redirect($url);} 				
	exit;
} 	/* batch lote */


$this->view->render($data,'shrinkages/filter');


}	/* fxn */


public function add(){
require_once(SITE.'functions/invis.php');
require_once(SITE.'functions/shrinkages.php');
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$data['today']=$today=$_SESSION['today'];

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['year']=DBYR;
	$post['ecid']=$_SESSION['ucid'];
	$db->add("{$dbg}.`30_shrinkages`",$post);
	$trml=$post['terminal'];
	$q="UPDATE {$dbo}.`03_products` SET `t$trml`=(`t$trml`-'".$post['qty']."'),
		`level`=(`level`-'".$post['qty']."'), 
		`level_currcost`=(`level_currcost`-'".$post['qty']."') 
		WHERE id='".$post['prid']."' LIMIT 1;";
	$db->query($q);		

	/* lccPocost */
	$prid=$post['prid'];
	$q=qryLevelcurrcostVsPocost($db,$prid);	
	$db->query($q);		
	
	$url="shrinkages/filter?filter&dateone={$today}&datetwo={$today}&limits=100&page=1";
	flashRedirect($url,'Added shrinkage.');
}	/* post */

$data['refno']=getRefno($db);
$data['sktypes']=fetchRows($db,"{$dbo}.sktypes");
$this->view->render($data,'shrinkages/add');

}	/* fxn */


public function edit($params=NULL){
require_once(SITE.'functions/shrinkages.php');
$data['skid']=$skid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$orig=$_POST['orig'];	
	updateShrinkage($db,$skid,$post,$orig);

	$url="shrinkages/edit/$skid";
	flashRedirect($url,'Shrinkage updated.');
}	/* post */


$data['row']=getShrinkage($db,$skid,$dbg);
$data['sktypes']=fetchRows($db,"{$dbo}.sktypes");
$this->view->render($data,'shrinkages/edit');

}	/* fxn */


public function delete($params=NULL){
$data['skid']=$skid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$q="SELECT * FROM {$dbg}.`30_shrinkages` WHERE id='$skid' LIMIT 1; ";
$sth=$db->querysoc($q);
$post=$sth->fetch();
$trml=$post['terminal'];
$q="DELETE FROM {$dbg}.`30_shrinkages` WHERE id='$skid' LIMIT 1; ";

$q.="UPDATE {$dbo}.`03_products` SET `t$trml`=(`t$trml`+'".$post['qty']."'),
	`level`=(`level`+'".$post['qty']."') 
	WHERE id='".$post['prid']."' LIMIT 1;";

// pr($q);exit;
$db->query($q);
flashRedirect('shrinkages/filter',"Shrinkage $skid deleted.");


}	/* fxn */



public function batch($params=NULL){
$db=&$this->model->db;
require_once(SITE."functions/invis.php");
require_once(SITE."functions/inventory.php");
require_once(SITE."functions/suppliers.php");
require_once(SITE."functions/shrinkages.php");
$dbo=PDBO;$dbg=PDBG;
$data['today']=$today=$_SESSION['today'];
$data['year']=$year=DBYR;

if(isset($_POST['submit'])){
	$posts=$_POST['positems'];
	$reference=$_POST['reference'];
	$ecid=$_SESSION['ucid'];$date=$_SESSION['today'];
	$q="";
	foreach($posts AS $post){
		if($post['product_id']>0){
		$q.="INSERT INTO {$dbg}.`30_shrinkages`(year,ecid,date,prid,sktype_id,terminal,qty,price,cost,remarks,reference) VALUES 
			('$year','$ecid','$date','".$post['product_id']."','".$post['sktype_id']."','".$post['terminal']."',
				'".$post['qty']."','".$post['price']."','".$post['cost']."','".$post['remarks']."','$reference');";	

			$trml=$post['terminal'];
			$q.="UPDATE {$dbo}.`03_products` SET `t$trml`=(`t$trml`-'".$post['qty']."'),
				`level`=(`level`-'".$post['qty']."'), 
				`level_currcost`=(`level_currcost`-'".$post['qty']."')
				WHERE id='".$post['product_id']."' LIMIT 1;";
								
		}		

	}
	// pr($q);exit;
	$db->querysoc($q);
	
	/* 2 level_currcost */
	$posts=$_POST;	
	$pridr = buildArray($posts['positems'],'product_id');
	$q="";
	foreach($pridr AS $prid){ $q.=qryLevelcurrcostVsPocost($db,$prid); }
	$db->query($q);	
	
	flashRedirect('shrinkages/filter','Shrinkages added.');
	exit;
}	/* post */


$data['refno']=getRefno($db);
$data['sktypes']=fetchRows($db,"{$dbo}.sktypes");

$this->view->render($data,'shrinkages/batch');

}	/* fxn */




public function lote($params){	/* batch lot edit */
$db=&$this->model->db;
require_once(SITE."functions/shrinkages.php");
$dbo=PDBO;$dbg=PDBG;
$data['today']=$today=$_SESSION['today'];

$data['rows']=array();
foreach($params as $skid){ $data['rows'][] = getShrinkage($db,$skid,$dbg); }			
$data['count']=count($data['rows']);

if(isset($_POST['submit'])){
	// pr($_POST);
	$ps=$_POST['ps'];
	foreach($ps AS $p){
		$post=$p['post'];
		$orig=$p['orig'];
		$skid=$post['skid'];	
		// pr($skid);
		updateShrinkage($db,$skid,$post,$orig);		
	}
	$strids=stringify($params);
	$url="shrinkages/lote/$strids";
	flashRedirect($url,'Edited.');	
	exit;
} 	/* post */


$this->view->render($data,'shrinkages/lote');



}	/* fxn */





}	/* ShrinkagesController */



