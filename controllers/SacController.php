<?php

Class SacController extends Controller{	

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
	echo "SAC index";
	// $this->view->render($data,'tests/index');

}	/* fxn */



public function sacs($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/sacs.php");
$dept_id=isset($params[0])? $params[0] : 1;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
$data['dept_id']=$dept_id;

switch($dept_id){
	case 1: $data['dept'] = 'PS'; break;
	case 2: $data['dept'] = 'GS'; break;
	case 3: $data['dept'] = 'HS'; break;
}

if(isset($_POST['update'])){	
	$rows = $_POST['sacs'];
	$q = "";
	foreach($rows AS $row){
		$sacid=$row['sacid'];$hcid=$row['hcid'];
		$q .= " UPDATE {$dbg}.`05_subjects_coordinators` SET `hcid` = '$hcid'
			 WHERE `id` = '$sacid' LIMIT 1; ";			
	}	 
	$db->query($q);
	redirect('sac/sacs/'.$dept_id.DS.$sy);

}	/* update */

if(isset($_POST['add'])){
	$rows = $_POST['sacs'];
	$q = " INSERT INTO {$dbo}.`05_subjects`_coordinators (`subject_id`,`hcid`,`department_id`) VALUES ";
	foreach($rows AS $row){
		$subid=$row['subid'];$hcid=$row['hcid'];
		$q.="('$subid','$hcid','$dept_id'),";		
	}
	$q = rtrim($q,",");$q .= ";";	 
	$db->query($q);
	redirect('sac/sacs/'.$dept_id.DS.$sy);

}	/* add */

$data['sacs']=sacs($db,$dept_id,$dbg);
$data['subjects'] 		= fetchRows($db,"{$dbo}.`05_subjects`","id,name","name"," WHERE is_active = 1 ");
$data['coordinators'] 	= getContacts($db,RACAD);
$data['departments']	= fetchRows($db,"{$dbo}.`05_departments`",'id,name','name',' WHERE `id` < 6 ');	
$data['num_sacs']		= count($data['sacs']);
$data['num_subjects']	= count($data['subjects']);
$vfile='sac/sacs';vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function delsac($params){
$dbo=PDBO;
$dept_id = $params[0];
$sacid 	 = $params[1];

$ssy	= $_SESSION['sy'];
$sy 	= isset($params[2])? $params[2]:$ssy;
$current = ($sy==$ssy)? true:false;

$dbg = ($current)? DBM:$sy.US.DBG;

$q = " DELETE FROM {$dbo}.`05_subjects`_coordinators WHERE `id` = '$sacid' LIMIT 1;  ";
$this->model->db->query($q);
redirect('mis/sacs/'.$dept_id.DS.$sy);


}	/* fxn */







}	/* SacController */
