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
	$data['feetypes'] = feetypes($db,$dbg,$order);	
	$data['num_feetypes'] = count($data['feetypes']);
	if(isset($_POST['add'])){
		$rows = $_POST['feetypes'];
		$q = "";
		$id = $this->model->lastID("{$dbo}.`03_feetypes`");
		foreach($rows AS $row){
			$id+=1;
			$pid = trim($row['parent_id']);
			$parent_id = ($pid>0)? $pid:$id;
			$name = trim($row['name']);
			$is_discount = trim($row['is_discount']);
			$amount = trim($row['amount']);
			$percentage = trim($row['percentage']);
			$position = trim($row['position']);
			$q .= " INSERT INTO {$dbo}.`03_feetypes` (`id`,`parent_id`,`name`,`is_discount`,`amount`,`percentage`,`position`) 
				VALUES ('$id','$parent_id','$name','$is_discount','$amount','$percentage','$position'); ";
		}
		// pr($q); exit;
		$_SESSION['q'] = $q;
		$this->model->db->querysoc($q);
		$url = "tfeetypes/table/$sy";
		redirect($url);
		exit;
	}

	
	$this->view->render($data,'tfeetypes/tableTfeetypes');
	
}	/* fxn */


public function edit($params){
$dbo=PDBO;
$data['ftid'] = $ftid = $params[0];
$dbg = PDBG;

if(isset($_POST['submit'])){
			// $parent_id = ($pid>0)? $pid:$id;

$parent_id = ($_POST['parent_id']>0)? trim($_POST['parent_id']):$ftid;
$name = trim($_POST['name']);
$is_discount = trim($_POST['is_discount']);
$amount = trim($_POST['amount']);
$percentage = trim($_POST['percentage']);
$position = trim($_POST['position']);
$combo = trim($_POST['combo']);

$q = "
	UPDATE {$dbo}.`03_feetypes` SET 
		`parent_id` = '$parent_id',
		`name` = '$name',
		`is_discount` = '$is_discount',
		`amount` = '$amount',
		`percentage` = '$percentage',
		`position` = '$position',
		`combo` = '$combo'
	WHERE `id` = '$ftid' LIMIT 1;	
";

$this->model->db->query($q);
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
