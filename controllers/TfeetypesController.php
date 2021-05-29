<?php

Class TfeetypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index(){
	echo "Fees index.";
}

public function table($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');	
	require_once(SITE."functions/fees.php");
	$db =& $this->model->db;
	
	$order = (isset($_GET['pos']))? 'fty.position':'fty.name';
	$order = (isset($_GET['id']))? 'fty.id':'fty.name';
	$data['feetypes'] = feetypes($db,$dbg,$order);	
	$data['num_feetypes'] = count($data['feetypes']);
	$dbtable="{$dbo}.03_feetypes";
	if(isset($_POST['add'])){
		$rows = $_POST['feetypes'];
		$q = "";
		$id = $this->model->lastID("{$dbo}.`03_feetypes`");
		foreach($rows AS $row){
			$row['id']=++$id;
			$db->add($dbtable,$row);				
		}
		$url = "tfeetypes/table?id";
		flashRedirect($url,'Fees added.');
		exit;
	}

	
	$this->view->render($data,'tfeetypes/tableTfeetypes');
	
}	/* fxn */


public function edit($params){
$dbo=PDBO;
$data['ftid'] = $ftid = $params[0];
$dbg = PDBG;

if(isset($_POST['submit'])){
	$db=&$this->baseModel->db;
	$post=$_POST;
	unset($post['submit']);
	$dbtable="{$dbo}.03_feetypes";
	$db->update($dbtable,$post,"`id`=$ftid");
	$url = "tfeetypes/edit/$ftid";
	flashRedirect($url,'Fee type edited.');

}	/* post */

$q = "SELECT * FROM {$dbo}.`03_feetypes` WHERE `id` = '$ftid' LIMIT 1;";
$sth = $this->model->db->querysoc($q);
$data['row'] = $sth->fetch(); 
$data['feetypes'] = $this->model->fetchRows("{$dbo}.`03_feetypes`");

$this->view->render($data,'tfeetypes/editTfeetypes');


}	/* fxn */







}	/* TfeetypesController */
