<?php

Class PaymasterController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/indexPaymaster');
	

}	/* fxn */


public function all(){
require_once(SITE.'functions/hr.php');
$db=&$this->model->db;
$dbg=PDBG;$dbo=PDBO;
$cond="c.is_active=1 AND c.role_id>1 AND c.role_id<>'".RSUPP."' AND c.id=c.parent_id";
$q="SELECT c.id AS ecid,c.name AS employee,m.*,c.code AS emplcode,m.id AS pmid FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.06_paymaster AS m ON c.id=m.ecid WHERE $cond; ";
pr($q);
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$data['rows']=&$rows;
$data['count']=count($rows);


$this->view->render($data,'paymaster/allPaymaster');

}	/* fxn */


public function sync(){
$dbo=PDBO;
	require_once(SITE.'functions/sync_hr.php');
	$db=&$this->model->db;$dbg=PDBG;
	syncPaymaster($db);
	$home=$_SESSION['home'];
	flashRedirect($home,'Synced Paymaster');
	
}	/* fxn */


public function edit($params=NULL){
$pcid=isset($params[0])? $params[0]:false;
$data['pcid']=&$pcid;
$db=&$this->model->db;
$dbg=PDBG;

if(isset($_POST['submit'])){
	$posts=$_POST['post'];
	$rows=array();
	foreach($posts AS $k=>$v){
		$v=str_replace(",","",$v);
		$rows[$k]=$v;	
	}	
	$db->update("{$dbg}.06_paymaster",$rows,"`pcid`='$pcid'");
	$url='paymaster/view/'.$pcid;
	flashRedirect($url,'Edited paymaster.');
	
	
}	/* post */


if($pcid){
	$q="SELECT c.name AS employee,m.* 
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.06_paymaster AS m ON m.pcid=c.id
	WHERE m.pcid='$pcid' LIMIT 1; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
}	/* pmid */


$this->view->render($data,'paymaster/editPaymaster');

}	/* fxn */



public function view($params=NULL){
$pcid=isset($params[0])? $params[0]:false;
$data['pcid']=&$pcid;
$db=&$this->model->db;
$dbo=PDBO;

if($pcid){
	$q="SELECT c.name AS employee,m.* 
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.06_paymaster AS m ON m.pcid=c.id
	WHERE m.pcid='$pcid' LIMIT 1; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
}	/* pmid */


$this->view->render($data,'paymaster/viewPaymaster');

}	/* fxn */







}	/* BlankController */
