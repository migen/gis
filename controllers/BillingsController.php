<?php

Class BillingsController extends Controller{	

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


public function index($params=NULL){ 
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$db=&$this->model->db;
	$q="SELECT b.id,b.date,b.date_paid,b.date_done,b.reference,b.amount,t.name AS jobtype
		FROM {$dbo}.billings AS b
		LEFT JOIN {$dbo}.jobtypes AS t ON t.id=b.jobtype_id
		WHERE b.`sy`='$sy';
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	$this->view->render($data,'billings/index'); 
} 

public function view($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/billings.php");
	$data['id']=$id=isset($params[0])? $params[0]:false;
	$db=&$this->model->db;
	$data['row']=getBillingById($db,$id);
	$this->view->render($data,'billings/view');

}	/* fxn */


public function add(){
$dbo=PDBO;$db=&$this->model->db;
if(isset($_POST['submit'])){
	unset($_POST['submit']);
	$post=$_POST['post'];
	// pr($post);exit;
	$db->add("{$dbo}.billings",$post);
	flashRedirect('billings','New billing added.');
}	/* post */

$data['jobtypes']=$this->model->fetchRows("{$dbo}.jobtypes","id,code,name","id");		
$this->view->render($data,'billings/add');
}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/billings.php");
$data['id']=$id=isset($params[0])? $params[0]:false;
$db=&$this->model->db;
$data['row']=getBillingById($db,$id);
if(isset($_POST['submit'])){
	unset($_POST['submit']);
	$post=$_POST['post'];	
	$post['amount'] = str_replace(",","",$post['amount']);	
	$post['paid'] = str_replace(",","",$post['paid']);		
	$post['balance']=$post['amount']-$post['paid'];
	if(($post['balance']==0) && (empty($post['date_paid']))){ $post['date_paid']=$_SESSION['today']; }
	$db->update("{$dbo}.billings",$post,"`id`='$id'");
	$url="billings/view/$id";
	flashRedirect($url,'Billing updated.');
}	/* post */


$this->view->render($data,'billings/edit');

}	/* fxn */


	
	
}	/* BillingsController */
