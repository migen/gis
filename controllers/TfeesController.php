<?php

Class TfeesController extends Controller{	

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




public function details($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/fees.php");
	require_once(SITE."functions/feesFxn.php");
	$db =& $this->model->db;
	
	$data['level_id']	= $level_id 	= isset($params[0])? $params[0]:4;	
	$data['ssy'] = $ssy = DBYR;
	$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
	$data['current'] = $current = ($sy==DBYR)? true:false;
	$data['num'] = $num = isset($_GET['num'])? $_GET['num']:1;	
	$dbg = VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['update'])){
		$tuition = $_POST['tuition'];
		$level_id = $tuition['level_id'];
		unset($tuition['level_id']);
		$this->model->db->update("{$dbo}.`03_tuitions`",$tuition,"level_id='$level_id' AND `num` = '".$tuition['num']."' ");
			
		$this->model->db->query($q);
		$url = 'tfees/details/'.$level_id.DS.$sy.'?num='.$num;
		flashRedirect($url,'Reservation updated.');		
		
	}	/* update */

	
	if(isset($_POST['add'])){
		$amount = trim($_POST['amount']);
		$q = " INSERT INTO {$dbg}.03_tdetails (`level_id`,`num`,`feetype_id`,`amount`) VALUES (
			'".$_POST['level_id']."','".$_POST['num']."','".$_POST['feetype_id']."','$amount' 
		); ";

		$q .= " UPDATE {$dbo}.`03_tuitions` SET `total` = `total` + '".$_POST['amount']."' WHERE 
			`level_id` = '".$_POST['level_id']."' AND `num` = '$num' LIMIT 1; ";

		$this->model->db->query($q);
		$url = 'tfees/details/'.$level_id.DS.$sy.'?num='.$num;
		redirect($url);
		
	}	/* post-add */

	$data['tuition'] 	= tuition($db,$level_id,$num,$dbg);		
	$data['fees'] 		= fees($db,$level_id,$num,$dbg);		
	$data['num_fees']	= count($data['fees']);
	
	$data['feetypes'] = $this->model->fetchRows("{$dbo}.`03_feetypes`","id,name","name");		
	$data['levels']			= $this->model->fetchRows("{$dbo}.`05_levels`","id,code,name","id");			
	$data['today'] = $_SESSION['today'];
	$this->view->render($data,'tfees/details');

}	/* fxn */



public function edit($params){
$dbo=PDBO;
	require_once(SITE."functions/fees.php");
	$db =& $this->model->db;

	$tuition_detail_id  = $params[0];		
	$data['ssy'] = $ssy	= $_SESSION['sy'];	
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$dbyr=DBYR;
	$data['current'] = $current = ($sy==$dbyr)? true:false;
	$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
		
	if(isset($_POST['edit'])){
		// pr($_POST);
		$q = " UPDATE {$dbg}.03_tdetails SET `feetype_id` = '".$_POST['feetype_id']."',
			`amount` = '".$_POST['amount']."' WHERE `id` = '".$tuition_detail_id."' LIMIT 1; ";
		
		$differential = $_POST['amount'] - $_POST['old_amount'];
		$q .= " UPDATE {$dbo}.`03_tuitions` SET `total` = `total` + $differential 
			WHERE `level_id` = '".$_POST['level_id']."' LIMIT 1; ";
		
		$this->model->db->query($q);
		$url = "tfees/details/".$_POST['level_id']."/$sy";
		flashRedirect($url,'Changes saved.');
		exit;
		
	}	/* post-edit */
	
	$data['fee'] = getFeeDetails($db,$tuition_detail_id,$dbg);
	$data['feetypes'] = feeTypes($db,$dbg);
	$this->view->render($data,'tfees/edit');

}	/* fxn */




public function delete($params){
$dbo=PDBO;
	$tuition_detail_id  = $params[0];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1]:$ssy;
	$current = ($sy==$ssy)? true:false;
	$dbg	= VCPREFIX.$sy.US.DBG;

	$q = " SELECT * FROM {$dbg}.03_tdetails WHERE `id` = '$tuition_detail_id' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$level_id = $row['level_id'];
	
	$q  = " DELETE FROM {$dbg}.03_tdetails WHERE `id` = '$tuition_detail_id' LIMIT 1; ";
	$q .= " UPDATE {$dbo}.`03_tuitions` SET `total` = `total` - '".$row['amount']."' WHERE `level_id` = '$level_id' LIMIT 1;  ";

	$this->model->db->query($q);	
	$url = 'tfees/details/'.$level_id.DS.$sy;
	flashRedirect($url,'Fee deleted.');
	

}	/* fxn */



public function table($params=NULL){
$dbo=PDBO;
$db=&$this->model->db;
$dbyr=DBYR;
$sy=isset($params[0])? $params[0]:$dbyr;
$dbg=VCPREFIX.$sy.US.DBG;
$dbg=&$dbg;

$q = "SELECT *,level_id AS lvlid,id AS tid FROM {$dbo}.`03_tuitions` ORDER BY level_id ASC;";
$sth = $db->querysoc($q);
$data['rows'] = $rows = $sth->fetchAll();
$data['count'] = count($rows);

if(isset($_POST['update'])){
	$posts = $_POST['posts'];
	foreach($posts AS $post){
		$id=$post['id'];
		$db->update("{$dbo}.`03_tuitions`",$post," `id` = '$id'  ");		
	}	/* foreach */
	$url="tfees/table/$sy";
	flashRedirect($url,'Tuition details updated.');
	exit;
	
}	/* post */

$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
$vfile='tfees/tableTfees';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */





}	/* TfeesController */
